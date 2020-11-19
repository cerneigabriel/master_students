<?php

namespace MasterStudents\Core;

use Carbon\Carbon;
use Collections\Map;
use MasterStudents\Models\User;
use MasterStudents\Core\Traits\DatabaseManagerTrait;

class Session
{
    use DatabaseManagerTrait;

    protected $table;
    protected $primaryKey;
    protected $session;
    protected $id;

    public function __construct()
    {
        $this->run();

        // Select current database and prepare repository for next queries
        $this->selectDatabase();

        if ($this->db->hasTable($this->table)) {
            $this->repository = $this->db->table($this->table);
            $this->insert = $this->db->insert($this->table);
        }

        return $this;
    }

    protected function attemptUserSession(User $user)
    {
        if ($this->db->hasTable($this->table)) {
            $created_at = Carbon::now()->toDateTimeString();

            if ($this->repository->where("session_id", $this->get("session_id"))->count() === 0) {
                $id = $this->repository->insertOne([
                    "user_id" => $user->id,
                    "active" => true,
                    "session_id" => $this->get("session_id"),
                    "session_data" => json_encode($this->session->toArray()),
                    "ip" => request()->ip(),
                    "created_at" => $created_at,
                    "updated_at" => $created_at
                ]);
                $this->session->set("id", $id);
            }
        }
    }

    private function run()
    {
        session_start();

        $this->table = Config::get("session.table");
        $this->primaryKey = Config::get("session.primaryKey");

        if (!isset($_SESSION["session_id"]))
            $_SESSION["session_id"] = bin2hex(random_bytes(64));

        $this->session = new Map($_SESSION);
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
            return (new self())->{$method}(...$arguments);
        } else return false;
    }

    private function get($path)
    {
        $path = explode(".", $path);
        $result = $this->session->toArray();

        $tries = 0;

        foreach ($path as $key) {
            if (isset($result[$key])) {
                $result = $result[$key];
                $tries++;
            }
        }

        if ($tries === count($path)) {
            return $result;
        } else {
            return false;
        }
    }

    private function set($key, $value)
    {
        $this->session->set($key, $value);

        $this->sync();

        return $this->get($key);
    }

    private function has($path)
    {
        $path = explode(".", $path);
        $result = $this->session->toArray();

        $tries = 0;

        foreach ($path as $key) {
            if (isset($result[$key])) {
                $result = $result[$key];
                $tries++;
            }
        }

        if ($tries === count($path)) {
            return true;
        } else {
            return false;
        }
    }

    private function forget($key)
    {
        $result = $this->session->toArray();

        if (isset($result[$key])) {
            unset($result[$key]);

            $this->session = new Map($result);
            $this->sync();

            return true;
        }

        return false;
    }

    private function sync()
    {
        $_SESSION = $this->session->toArray();
        $id = $this->session->get("id");

        if ($this->db->hasTable($this->table) && $this->repository->where($this->primaryKey, $id)->count() > 0) {
            $this->repository
                ->update(["session_data" => json_encode($this->session->toArray())])
                ->where($this->primaryKey, $id)
                ->run();
        }
    }

    private function getAuthenticatedSession()
    {
        $id = $this->session->get("id");

        $result = $this->repository->where($this->primaryKey, $id)->where("active", "1");
        return $result->count() > 0 ? $result->fetchAll()[0] : null;
    }

    private function getAuthenticated()
    {
        return !is_null($this->getAuthenticatedSession()) ? User::find($this->getAuthenticatedSession()["user_id"]) : null;
    }

    private function isAuthenticated()
    {
        return !is_null($this->getAuthenticated());
    }

    private function all()
    {
        return $this->session;
    }

    private function flash()
    {
        $id = $this->session->get("id");

        if ($this->db->hasTable($this->table) && $this->repository->where($this->primaryKey, $id)->count() > 0) {
            $this->repository
                ->update(["active" => false])
                ->where($this->primaryKey, $id)
                ->run();
        }

        $this->session = new Map([]);

        $this->sync();

        return true;
    }
}
