<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use MasterStudents\Core\Model;
use MasterStudents\Actions\RoleActions;
use MasterStudents\Actions\SecurityManagement\RolePermissionsManagement;

class Role extends Model
{
    use RolePermissionsManagement;
    use RoleActions;

    public $table = "roles";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "key",
        "name",
    ];

    public $relationships = [
        "users",
        "permissions",
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

    public static function updateRules()
    {
        return [
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
        return User::query(function ($query) {
            return $query
                ->select("users.*")
                ->innerJoin('user_role')
                ->on(['users.id' => 'user_role.user_id'])
                ->where('user_role.role_id', $this->id);
        })->get();
    }
}
