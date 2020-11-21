<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Traits\DatabaseManagerTrait;

class Job
{
  use DatabaseManagerTrait;

  public function __construct()
  {
    $this->selectDatabase();

    if (isset($this->table))
      $this->repository = $this->db->table($this->table);
  }
}
