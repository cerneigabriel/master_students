<?php

namespace MasterStudents\Core;

use Spiral\Database\Config\DatabaseConfig;
use Spiral\Database\DatabaseManager;
use MasterStudents\Core\Config;
use Collections\Map;
use Collections\Pair;

class Database
{
    public DatabaseManager $db;
    private array $credentials;

    public function __construct()
    {
        $this->collectDbCredentials();

        $this->db = new DatabaseManager(new DatabaseConfig($this->credentials));

        return $this;
    }

    private function collectDbCredentials(): void
    {
        $this->credentials = (array) Config::get("db.credentials");
    }
}
