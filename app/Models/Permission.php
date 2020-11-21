<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;

class Permission extends Model
{
    public $table = "permissions";
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

    public function roles()
    {
        return $this->query(function ($query) {
            return $query
                ->table("roles")
                ->innerJoin('role_permission')
                ->on(['roles.id' => 'role_permission.role_id'])
                ->onWhere('role_permission.permission_id', $this->id);
        })->get();
    }
}
