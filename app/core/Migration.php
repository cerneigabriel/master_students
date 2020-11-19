<?php

namespace MasterStudents\Core;

use Carbon\Carbon;
use ReflectionClass;
use MasterStudents\Core\Migrations;

class Migration extends Migrations
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        $migration = (new ReflectionClass(get_called_class()))->getShortName();

        return $this->repository->insertOne([
            "migration" => $migration,
            "created_at" => Carbon::now()->toDateTimeString()
        ]);
    }
}
