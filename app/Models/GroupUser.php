<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use MasterStudents\Actions\GroupsActions;
use MasterStudents\Actions\SecurityManagement\GroupUsersManagement;
use MasterStudents\Core\Model;

class GroupUser extends Model
{
    public $table = "group_user";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "group_id",
        "user_id",
        "role_id",
        "group_user_status_id",
        "token",
    ];

    public $relationships = [
        "group",
        "user",
        "role",
        "group_user_status",
    ];

    public $casts = [
        "id" => "integer",
        "group_id" => "integer",
        "user_id" => "integer",
        "role_id" => "integer",
        "group_user_status_id" => "integer",
        "token" => "string",
    ];

    public static function rules()
    {
        return [
            "group_id" => ["required", "exists_in_table:groups,id"],
            "user_id" => ["required", "exists_in_table:users,id"],
            "role_id" => ["required", "exists_in_table:roles,id"],
            "group_user_status_id" => ["required", "exists_in_table:group_user_statuses,id"],
        ];
    }

    public static function registrationRules()
    {
        return self::rules();
    }

    public static function updateRules()
    {
        return self::rules();
    }

    public static function adminUpdateRules()
    {
        return self::rules();
    }


    public static function generateToken()
    {
        $token = bin2hex(random_bytes(64));
        $tokens = map((new self)->repository->select()->columns("token")->fetchAll())->map(fn ($value) => ($value["token"]))->toArray();

        while (in_array($token, $tokens)) $token = bin2hex(random_bytes(64));
        return $token;
    }

    
    public function group() {
        return Group::find($this->group_id);
    }
    
    public function user() {
        return User::find($this->user_id);
    }
    
    public function role() {
        return Role::find($this->role_id);
    }
    
    public function group_user_status() {
        return GroupUserStatus::find($this->group_user_status_id);
    }
}
