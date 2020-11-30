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
        "user_id",
        "name",
        "year"
    ];

    public $relationships = [
        "user",
        "users",
    ];

    public $casts = [
        "id" => "integer",
        "user_id" => "integer",
        "name" => "string",
        "year" => "string",
    ];

    public static function rules()
    {
        return [
            "user_id" => ["required", "exists_in_table:users,id"],
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

    public function leader()
    {
        return User::find($this->user_id);
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

    public function hasStudent(User $user)
    {
        return in_array($user->id, map($this->masterStudents())->map(fn ($v) => $v->id)->toArray());
    }

    public function detachAllUsers()
    {
        $this->db
            ->table("group_user")
            ->delete()
            ->where("group_id", $this->id)
            ->run();
    }

    public function detachStudent(User $user)
    {
        if ($this->hasStudent($user))
            $this->db
                ->table("group_user")
                ->delete()
                ->where("group_id", $this->id)
                ->where("user_id", $user->id)
                ->run();
    }

    public function attachStudent(User $user)
    {
        if (!$this->hasStudent($user)) {
            $this->db
                ->insert("group_user")
                ->values([
                    "group_id" => $this->id,
                    "user_id" => $user->id,
                    "activated" => false,
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ])
                ->run();
        }
    }
}
