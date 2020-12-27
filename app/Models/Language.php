<?php

namespace MasterStudents\Models;

use MasterStudents\Core\Model;
use MasterStudents\Actions\LanguagesActions;

class Language extends Model
{
    use LanguagesActions;

    public $table = "languages";
    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "locale",
        "name",
    ];

    public $relationships = [];

    public $casts = [
        "id" => "integer",
        "locale" => "string",
        "name" => "string",
    ];

    public static function rules()
    {
        return [
            "locale" => ["required", "max:10", "unique:languages,locale"],
            "name" => ["required", "max:100"]
        ];
    }

    public static function registrationRules()
    {
        return self::rules();
    }

    public static function updateRules()
    {
        return [
            "name" => self::rules()["name"]
        ];
    }
}
