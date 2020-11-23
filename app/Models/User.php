<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use MasterStudents\Core\Model;
use MasterStudents\Actions\UserActions;
use Collections\Map;

class User extends Model
{
    use UserActions;

    public $table = "users";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "first_name",
        "last_name",
        "username",
        "email",
        "password",
        "email_verified",
        "birth_date",
        "phone",
        "company",
        "speciality",
        "gender",
        "notes",
        "zoom_link"
    ];

    public $relationships = [
        "roles",
        "sessions",
        "permissions"
    ];

    public $casts = [
        "id" => "integer",
        "username" => "string",
        "first_name" => "string",
        "last_name" => "string",
        "email" => "string",
        "password" => "string",
        "email_verified" => "boolean",
        "birth_date" => "string",
        "phone" => "string",
        "company" => "string",
        "speciality" => "string",
        "gender" => "string",
        "notes" => "string",
        "zoom_link" => "string",
    ];

    public static function rules()
    {
        return [
            "username" => ["required", "max:50"],
            "first_name" => ["required", "max:50"],
            "last_name" => ["required", "max:50"],
            "email" => ["required", "email", "max:100"],
            "password" => ["required", "min:6", "max:255"],
            "password_confirm" => ["required", "same:password"],
            "birthdate" => ["required", "date"],
            "phone" => ["required", "max:20"],
            "company" => ["required", "max:100"],
            "speciality" => ["required", "max:100"],
            "gender" => ["required", "max:10", "in:m,f"],
            "notes" => ["required", "max:65535"],
        ];
    }

    public static function registrationRules()
    {
        return [
            "username" => [...self::rules()["username"], "unique:users,username"],
            "email" => [...self::rules()["email"], "unique:users,email"]
        ] + array_filter(self::rules(), fn ($v, $k) => in_array($k, [
            "first_name",
            "last_name",
            "password",
            "password_confirm"
        ]), ARRAY_FILTER_USE_BOTH);
    }

    public static function updateRules()
    {
        return [
            "username" => [...self::rules()["username"]],
            "email" => [...self::rules()["email"]]
        ] + array_filter(self::rules(), fn ($v, $k) => in_array($k, [
            "first_name",
            "last_name",
            "birthdate",
            "phone",
            "company",
            "speciality",
            "gender",
            "notes"
        ]), ARRAY_FILTER_USE_BOTH);
    }

    public static function adminUpdateRules()
    {
        return [
            "username" => ["required", "max:50"],
            "first_name" => ["required", "max:50"],
            "last_name" => ["required", "max:50"],
            "email" => ["required", "email", "max:100"],
            "birthdate" => ["", "date"],
            "phone" => ["", "max:20"],
            "company" => ["", "max:100"],
            "speciality" => ["", "max:100"],
            "gender" => ["", "max:10", "in:m,f"],
            "notes" => ["", "max:65535"],
        ];
    }

    public static function loginRules()
    {
        return [
            "email" => ["required", "exists_in_table:users,email"]
        ] + array_filter(self::rules(), fn ($v, $k) => in_array($k, [
            "email",
            "password"
        ]), ARRAY_FILTER_USE_BOTH);
    }

    public function roles()
    {
        return Role::query(function ($query) {
            return $query
                ->select("roles.*")
                ->innerJoin('user_role')
                ->on(['roles.id' => 'user_role.role_id'])
                ->onWhere('user_role.user_id', $this->id);
        })->get();
    }

    public function sessions()
    {
        return UserSession::query(fn ($q) => $q->select("sessions.*")->where('sessions.user_id', $this->id))->get();
    }

    public function permissions()
    {
        return Permission::query(function ($query) {
            return $query
                ->select("permissions.*")
                ->innerJoin('role_permission')
                ->on(['permissions.id' => 'role_permission.permission_id'])

                ->innerJoin('user_role')
                ->on(['role_permission.role_id' => 'user_role.role_id'])

                ->onWhere('user_role.user_id', $this->id);
        })->get();
    }

    public function hasRole(Role $role)
    {
        return in_array($role->id, map($this->roles())->map(fn ($v) => $v->id)->toArray());
    }

    public function detachAllRoles()
    {
        $this->db
            ->table("user_role")
            ->delete()
            ->where("user_id", $this->id)
            ->run();
    }

    public function detachRole(Role $role)
    {
        $this->db
            ->table("user_role")
            ->delete()
            ->where("user_id", $this->id)
            ->where("role_id", $role->id)
            ->run();
    }

    public function attachRole(Role $role)
    {
        if (!$this->hasRole($role)) {
            $this->db
                ->insert("user_role")
                ->values([
                    "user_id" => $this->id,
                    "role_id" => $role->id,
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ])
                ->run();
        }
    }
}
