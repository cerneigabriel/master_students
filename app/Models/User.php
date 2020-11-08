<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;

class User extends Model
{
    public $table = "users";
    public $primaryKey = "id";

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
        "first_name" => "string",
        "last_name" => "string",
        "email" => "string",
        "password" => "string",
        "birthdate" => "string",
        "phone" => "string",
        "company" => "string",
        "speciality" => "string",
        "gender" => "string",
        "notes" => "string"
    ];

    public static function rules()
    {
        return [
            "first_name" => ["required", "max:255"],
            "last_name" => ["required", "max:255"],
            "email" => ["required", "email", "max:255"],
            "password" => ["required", "min:6"],
            "password_confirm" => ["required", "same:password"],
            "birthdate" => ["required", "date"],
            "phone" => ["required"],
            "company" => ["required"],
            "speciality" => ["required"],
            "gender" => ["required"],
            "notes" => ["required"],
        ];
    }
}
