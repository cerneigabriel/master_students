<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Traits\DatabaseManagerTrait;

abstract class Controller
{
    use DatabaseManagerTrait;
    use ControllerHandler;

    public function __construct()
    {
        $this->selectDatabase();

        if (isset($this->table))
            $this->repository = $this->db->table($this->table);
    }
}
