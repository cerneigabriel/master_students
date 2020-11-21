<?php

namespace MasterStudents\Core\Traits;

use Spiral\Database\DatabaseManager;

trait DatabaseManagerTrait
{
    protected DatabaseManager $database_manager;
    public $db;

    public function setDbManager(DatabaseManager $db)
    {
        $this->database_manager = $db;
        $this->db = $this->database_manager->database();

        return $this;
    }

    public function selectDatabase($database = null)
    {
        $this->database_manager = app()->database->db;

        if (is_null($database))
            $this->db = $this->database_manager->database();
        else
            $this->db = $this->database_manager->database($database);

        return $this;
    }
}
