<?php

namespace MasterStudents\Actions;

use MasterStudents\Models\Language;

trait LanguagesActions
{
  public static function createAction(array $data)
  {
    $validator = request()->validate(Language::registrationRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "created" => false,
      "validator" => $validator
    ];

    try {
      $language = Language::create($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "created" => true,
      "language" => $language
    ];
  }

  public static function updateAction(array $data, $id)
  {
    $validator = request()->validate(Language::updateRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "updated" => false,
      "validator" => $validator
    ];

    try {
      $language = Language::find($id)->update($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "updated" => true,
      "language" => $language
    ];
  }

  public static function deleteAction($id)
  {
    try {
      Language::find($id)->delete();
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "deleted" => true
    ];
  }
}
