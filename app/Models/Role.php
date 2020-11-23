<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use MasterStudents\Core\Model;
use MasterStudents\Actions\RoleActions;

class Role extends Model
{
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

    public function permissions()
    {
        return Permission::query(function ($query) {
            return $query
                ->select("permissions.*")
                ->innerJoin('role_permission')
                ->on(['permissions.id' => 'role_permission.permission_id'])
                ->where('role_permission.role_id', $this->id);
        })->get();
    }

    public function hasPermission(Permission $permission)
    {
        return in_array($permission->id, map($this->permissions())->map(fn ($v) => $v->id)->toArray());
    }

    public function detachAllPermissions()
    {
        $this->db
            ->table("role_permission")
            ->delete()
            ->where("role_id", $this->id)
            ->run();
    }

    public function detachPermission(Permission $permission)
    {
        $this->db
            ->table("role_permission")
            ->delete()
            ->where("role_id", $this->id)
            ->where("permission_id", $permission->id)
            ->run();
    }

    public function attachPermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            $this->db
                ->insert("role_permission")
                ->values([
                    "role_id" => $this->id,
                    "permission_id" => $permission->id,
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ])
                ->run();
        }
    }
}
