<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;
use MasterStudents\Actions\PermissionsActions;

class Permission extends Model
{
    use PermissionsActions;

    public $table = "permissions";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "key",
        "name",
    ];

    public $relationships = [
        "roles"
    ];

    public $casts = [
        "id" => "integer",
        "key" => "string",
        "name" => "string",
    ];

    public static function rules()
    {
        return [
            "key" => ["required", "max:50", "unique:roles,key"],
            "name" => ["required", "max:100"]
        ];
    }

    public static function registrationRules()
    {
        return [
            "key" => self::rules()["key"],
            "name" => self::rules()["name"]
        ];
    }

    public static function updateRules()
    {
        return [
            "name" => self::rules()["name"]
        ];
    }

    public function roles()
    {
        return Role::query(function ($query) {
            return $query
                ->select("roles.*")
                ->innerJoin('role_permission')
                ->on(['roles.id' => 'role_permission.role_id'])
                ->where('role_permission.permission_id', $this->id);
        })->get();
    }
}
