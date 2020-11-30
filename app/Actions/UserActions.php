<?php

namespace MasterStudents\Actions;

use MasterStudents\Core\Hash;
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
      $data["password"] = Hash::make($data["password"]);

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
      $user = User::find($id)->update(map($data)->filterWithKey(fn ($v, $k) => $k != "password")->toArray());
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

  public static function changePasswordAction(array $data, $id)
  {
    if (is_null(User::find($id))) return (object) [
      "server_error" => true
    ];

    $validator = request()->validate(User::changePasswordRules(User::find($id)));


    if ($validator->fails()) return (object) [
      "server_error" => false,
      "updated" => false,
      "validator" => $validator
    ];

    try {
      $user = User::find($id)->update(["password" => Hash::make($data["password"])]);
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
      if (!is_null(User::find($id))) {
        User::find($id)->delete();
      }
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
