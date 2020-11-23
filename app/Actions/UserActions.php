<?php

namespace MasterStudents\Actions;

use MasterStudents\Models\User;

trait UserActions
{
  public static function createAction(array $data, string $rulesCollectionName = "registrationRules")
  {
    $validator = request()->validate(User::{$rulesCollectionName}());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "created" => false,
      "validator" => $validator
    ];

    try {
      $user = User::create($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "created" => true,
      "user" => $user
    ];
  }

  public static function updateAction(array $data, $id, string $rulesCollectionName = "updateRules")
  {
    $validator = request()->validate(User::{$rulesCollectionName}());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "updated" => false,
      "validator" => $validator
    ];

    try {
      $user = User::find($id)->update($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "updated" => true,
      "user" => $user
    ];
  }

  public static function deleteAction($id)
  {
    try {
      User::find($id)->delete();
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
