<?php

namespace MasterStudents\Actions;

use MasterStudents\Models\Role;

trait RoleActions
{
  public static function createAction(array $data)
  {
    $validator = request()->validate(Role::registrationRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "created" => false,
      "validator" => $validator
    ];

    try {
      $role = Role::create($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "created" => true,
      "role" => $role
    ];
  }

  public static function updateAction(array $data, $id)
  {
    $validator = request()->validate(Role::updateRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "updated" => false,
      "validator" => $validator
    ];

    $data = array_filter($data, fn ($v, $k) => $k !== "key", ARRAY_FILTER_USE_BOTH);

    try {
      $role = Role::find($id)->update($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "updated" => true,
      "role" => $role
    ];
  }

  public static function deleteAction($id)
  {
    try {
      Role::find($id)->delete();
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
