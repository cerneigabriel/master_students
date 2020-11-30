<?php

namespace MasterStudents\Core\Validation;

use MasterStudents\Core\Hash;
use MasterStudents\Core\Traits\DatabaseManagerTrait;
use Rakit\Validation\Rule;

class PasswordMatch extends Rule
{
    use DatabaseManagerTrait;

    protected $implicit = true;

    protected $message = ":attribute does not match exiting password.";

    protected $fillableParams = ['table', 'password_column', 'id_column', 'id'];

    public function __construct()
    {
        $this->selectDatabase();
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'id_column', 'password_column', 'id']);

        // getting parameters
        $table = $this->parameter('table');
        $id_column = $this->parameter('id_column');
        $password_column = $this->parameter('password_column');
        $id = $this->parameter('id');

        // do query
        $result = $this->db->table($table)->where($id_column, $id)->columns([$password_column]);

        if ($result->count() > 0 && Hash::check($value, $result->fetchAll()[0][$password_column]))
            return true;

        // true for valid, false for invalid
        return false;
    }
}
