<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;
use Collections\Map;

class User extends Model
{
    public $table = "users";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "birthdate",
        "phone",
        "company",
        "speciality",
        "gender",
        "notes"
    ];

    public $casts = [
        "id" => "integer",
        "username" => "string",
        "first_name" => "string",
        "last_name" => "string",
        "email" => "string",
        "password" => "string",
        "remember_token" => "string",
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
            "gender" => ["required", "max:10"],
            "notes" => ["required", "max:65535"],
        ];
    }

    public static function registrationRules()
    {
        return [
            "username" => ["required", "unique:users,username"],
            "email" => ["required", "email", "unique:users,email"]
        ] + array_filter(self::rules(), function ($value, $key) {
            return in_array($key, [
                "first_name",
                "last_name",
                "email",
                "password",
                "password_confirm"
            ]);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public static function loginRules()
    {
        $emails = (new Map((new self)->repository->select()->columns("email")->fetchAll()))->map(fn ($value) => ($value["email"]))->toArray();

        return [
            "email" => ["required", "in:" . implode(",", $emails)]
        ] + array_filter(self::rules(), function ($value, $key) {
            return in_array($key, [
                "email",
                "password",
            ]);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
