<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;

class GroupUserStatus extends Model
{
    public $table = "group_user_statuses";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "key",
        "name",
    ];

    public $relationships = [
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
}
