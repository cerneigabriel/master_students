<?php

namespace MasterStudents\Core;

use Collections\Map;

class Hash
{
    public $driver;

    private $drivers = [
        "bcrypt" => PASSWORD_BCRYPT,
        "argon2i" => PASSWORD_ARGON2I,
        "argon2id" => PASSWORD_ARGON2ID,
        "default" => PASSWORD_DEFAULT
    ];

    public function __construct()
    {
        $this->driver = Config::get("hash.driver");
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

    private function make($unhashed)
    {
        return password_hash($unhashed, $this->getEncryptionAlgorithmByDriver());
    }

    private function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    private function getEncryptionAlgorithmByDriver()
    {
        return $this->getDrivers()->get($this->driver);
    }

    private function getDrivers()
    {
        return new Map($this->drivers);
    }
}
