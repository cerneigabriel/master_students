<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Traits\DatabaseManagerTrait;
use Carbon\Carbon;
use Collections\Map;

abstract class Model
{
    use DatabaseManagerTrait;

    protected $repository;
    protected $insert;

    public function __construct()
    {
        $this->selectDatabase();
        $this->setRepository();
    }

    protected function setRepository()
    {
        $this->repository = $this->db->table($this->table);
        $this->insert = $this->db->insert($this->table);
    }

    public function __call($method, $arguments)
    {
        if (method_exists(self::class, $method)) {
            return $this->{$method}(...$arguments);
        } else return false;
    }

    public static function __callStatic($method, $arguments)
    {
        if (method_exists(self::class, $method)) {
            $class = get_called_class();
            $class = new $class;

            return (new $class())->{$method}(...$arguments);
        } else return false;
    }

    private function create(array $data)
    {
        if ($this->timestamps && !$this->hasTimestamps($data))
            $data = $this->setTimestamps($data, Carbon::now());

        $id = $this->insert->values($data)->run();
        $result = $this->repository->where($this->primaryKey, $id)->fetchAll();

        if (!empty($result)) return $this->convert($result[0]);

        return $this;
    }

    private function find($id)
    {
        $result = $this->repository->where($this->primaryKey, $id)->fetchAll();

        if (!empty($result)) return $this->convert($result[0]);

        return $this;
    }

    private function query($fn)
    {
        $this->result = $fn($this->repository)->fetchAll();

        return $this;
    }

    private function first()
    {
        return !empty($this->result) ? $this->convert($this->result[0]) : null;
    }

    private function get()
    {
        return $this->convertAll($this->result);
    }

    private function convert(array $instance)
    {
        $class = new $this;

        foreach ($instance as $property => $value) {

            if (isset($this->casts[$property])) {
                settype($value, $class->casts[$property]);
            }

            $class->{$property} = $value;
        }

        return $class;
    }

    private function convertArray(array $instances)
    {
        $result = [];

        foreach ($instances as $instance)
            $result[] = $this->convert($instance);

        return $result;
    }

    public function hasTimestamps(array $data)
    {
        return isset($data["created_at"]) && isset($data["updated_at"]);
    }

    public function setTimestamps(array $data, Carbon $timestamp): array
    {
        $data["created_at"] = $data["updated_at"] = $timestamp->toDateTimeString();

        return $data;
    }
}
