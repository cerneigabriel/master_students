<?php

namespace MasterStudents\Core\Validation;

use MasterStudents\Core\Traits\DatabaseManagerTrait;
use Rakit\Validation\Rule;

class ExistsInTableRule extends Rule
{
    use DatabaseManagerTrait;

    protected $implicit = true;

    protected $message = ":attribute not found";

    protected $fillableParams = ['table', 'column'];

    public function __construct()
    {
        $this->selectDatabase();
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');

        // do query
        $result = $this->db->table($table)->where($column, $value)->fetchAll();

        // true for valid, false for invalid
        return !empty($result);
    }
}
