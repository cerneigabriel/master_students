<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Traits\DatabaseManagerTrait;
use Carbon\Carbon;
use Collections\Map;
use ReflectionMethod;
use RuntimeException;

abstract class Model
{
    use DatabaseManagerTrait;

    protected $repository;
    protected $insert;
    protected $result;

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
        $data = array_filter($data, fn ($value, $key) => in_array($key, $this->fillable), ARRAY_FILTER_USE_BOTH);

        if ($this->timestamps && !$this->hasTimestamps($data))
            $data = $this->setTimestamps($data, Carbon::now());

        $id = $this->insert->values($data)->run();
        $result = $this->repository->where($this->primaryKey, $id)->fetchAll();

        if (!empty($result)) return $this->convert($result[0]);

        return $this;
    }

    private function update(array $data)
    {
        $data = array_filter($data, fn ($value, $key) => in_array($key, $this->fillable), ARRAY_FILTER_USE_BOTH);

        if ($this->timestamps && !$this->hasTimestamps($data))
            $data = $this->setUpdatedAt($data, Carbon::now());

        $this->repository->update($data)->where($this->primaryKey, $this->{$this->primaryKey})->run();
        $result = $this->repository->where($this->primaryKey, $this->{$this->primaryKey})->fetchAll();

        if (!empty($result)) return $this->convert($result[0]);

        return $this;
    }

    private function delete()
    {
        $this->repository->delete()->where($this->primaryKey, $this->{$this->primaryKey})->run();

        return true;
    }

    private function find($id)
    {
        $result = $this->repository->where($this->primaryKey, $id)->fetchAll();

        if (!empty($result)) return $this->convert($result[0]);

        return null;
    }

    private function query(callable $fn)
    {
        $this->result = $fn($this->repository, $this->db)->fetchAll();

        return $this;
    }

    private function first()
    {
        return !empty($this->result) ? $this->convert($this->result[0]) : null;
    }

    private function get()
    {
        return $this->convertArray($this->result);
    }

    private function all()
    {
        return $this->query(fn ($q) => $q)->get();
    }

    private function withRelations(array $relations)
    {
        foreach ($relations as $relation) {
            if (method_exists($this, $relation)) {
                $reflection = new ReflectionMethod($this, $relation);
                $this->{$relation} = $reflection->isStatic() ? $this::{$relation}() : $this->{$relation}();
            }
        }

        return $this;
    }

    private function convert(array $instance)
    {
        $class = new $this;

        foreach ($instance as $property => $value) {

            if (isset($this->casts[$property])) {
                if ($this->casts[$property] === "json")
                    $value = (array) json_decode($value);
                else
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

    public function setTimestamps(array $data, Carbon $timestamp)
    {
        $data["created_at"] = $data["updated_at"] = $timestamp->toDateTimeString();
        return $data;
    }

    public function setUpdatedAt(array $data, Carbon $timestamp)
    {
        $data["updated_at"] = $timestamp->toDateTimeString();
        return $data;
    }

    public function toArray(): array
    {
        $array = array(
            $this->primaryKey => $this->{$this->primaryKey}
        );

        $available_fields = array_merge($this->fillable, isset($this->relationships) ? $this->relationships : []);

        foreach ($available_fields as $field)
            if (isset($this->{$field}))
                $array[$field] = $this->{$field};

        return $array;
    }
}
