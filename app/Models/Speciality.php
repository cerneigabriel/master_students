<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;

class Speciality extends Model
{
    public $table = "specialities";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "language_id",
        "name",
        "abbreviation",
        "duration",
    ];

    public $relationships = [
        "roles"
    ];

    public $casts = [
        "id" => "integer",
        "language_id" => "integer",
        "name" => "name",
        "abbreviation" => "abbreviation",
        "duration" => "duration",
    ];

    public static function rules()
    {
        return [
            "language_id" => ["required", "exists_in_table:languages,id"],
            "name" => ["required", "max:255"],
            "abbreviation" => ["required", "max:255"],
            "duration" => ["required", "max:255"],
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

    public function languages()
    {
        return Role::query(function ($query) {
            return $query
                ->select("roles.*")
                ->innerJoin('role_permission')
                ->on(['roles.id' => 'role_permission.role_id'])
                ->where('role_permission.permission_id', $this->id);
        })->get();
    }
}
