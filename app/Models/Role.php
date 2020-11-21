<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;

class Role extends Model
{
    public $table = "roles";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "key",
        "name",
    ];

    public $casts = [
        "id" => "integer",
        "key" => "string",
        "name" => "string",
    ];

    public static function rules()
    {
        return [
            "key" => ["required", "max:50"],
            "name" => ["required", "max:100"]
        ];
    }

    public static function registrationRules()
    {
        return [
            "key" => ["required", "max:50", "unique:roles,key"],
            "name" => self::rules()["name"]
        ];
    }

    public function users()
    {
        return $this->query(function ($query) {
            return $query
                ->table("users")
                ->innerJoin('user_role')
                ->on(['users.id' => 'user_role.user_id'])
                ->onWhere('user_role.role_id', $this->id);
        })->get();
    }

    public function permissions()
    {
        return $this->query(function ($query) {
            return $query
                ->table("permissions")
                ->innerJoin('role_permission')
                ->on(['permissions.id' => 'role_permission.permission_id'])
                ->onWhere('role_permission.role_id', $this->id);
        })->get();
    }
}
