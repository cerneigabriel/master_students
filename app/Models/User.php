<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use MasterStudents\Core\Model;
use MasterStudents\Actions\UserActions;
use Collections\Map;
use MasterStudents\Actions\SecurityManagement\UserPermissionsManagement;
use MasterStudents\Actions\SecurityManagement\UserRolesManagement;

class User extends Model
{
    use UserRolesManagement, UserPermissionsManagement, UserActions;

    public $table = "users";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "user_status_id",
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
        "user_status",
        "roles",
        "sessions",
        "permissions",
        "all_permissions"
    ];

    public $casts = [
        "id" => "integer",
        "user_status_id" => "integer",
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
            "user_status_id" => ["required", "exists_in_table:user_statuses,id"],
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

    public static function changePasswordRules(User $user)
    {
        return [
            "old_password" => ["required", "min:6", "max:255", "password_match:users,password,{$user->primaryKey},{$user->{$user->primaryKey}}"],
            "password" => ["required", "min:6", "max:255"],
            "password_confirm" => ["required", "same:password"],
        ];
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

    public function sessions()
    {
        return UserSession::query(fn ($q) => $q->select("sessions.*")->where('sessions.user_id', $this->id))->get();
    }

    public function user_status() {
        return UserStatus::find($this->user_status_id);
    }
}
