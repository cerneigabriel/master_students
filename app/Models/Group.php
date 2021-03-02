<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use MasterStudents\Actions\GroupsActions;
use MasterStudents\Actions\SecurityManagement\GroupUsersManagement;
use MasterStudents\Core\Model;

class Group extends Model
{
    use GroupsActions, GroupUsersManagement;

    public $table = "groups";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "speciality_id",
        "name",
        "year"
    ];

    public $relationships = [
        "users",
        "members",
        "speciality"
    ];

    public $casts = [
        "id" => "integer",
        "speciality_id" => "integer",
        "name" => "string",
        "year" => "string",
    ];

    public static function rules()
    {
        return [
            "speciality_id" => ["required", "exists_in_table:specialities,id"],
            "name" => ["required", "max:50"],
            "year" => ["required", "date:Y"],
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

    public function speciality()
    {
        return Speciality::find($this->speciality_id);
    }

    public function users()
    {
        return User::query(function ($q) {
            return $q
                ->select("users.*")
                ->innerJoin('group_user')
                ->on(['users.id' => 'group_user.user_id'])
                ->where('group_user.group_id', $this->id);
        })->get();
    }

    public function members() {
        return GroupUser::query(fn ($q) => $q->where("group_id", $this->id))->get();
    }
}
