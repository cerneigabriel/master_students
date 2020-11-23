<?php

namespace MasterStudents\Actions;

use MasterStudents\Models\Permission;

trait PermissionActions
{
  public static function createAction(array $data)
  {
    $validator = request()->validate(Permission::registrationRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "created" => false,
      "validator" => $validator
    ];

    try {
      $permission = Permission::create($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "created" => true,
      "permission" => $permission
    ];
  }

  public static function updateAction(array $data, $id)
  {
    $validator = request()->validate(Permission::updateRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "updated" => false,
      "validator" => $validator
    ];

    $data = array_filter($data, fn ($v, $k) => $k !== "key", ARRAY_FILTER_USE_BOTH);

    try {
      $permission = Permission::find($id)->update($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "updated" => true,
      "permission" => $permission
    ];
  }

  public static function deleteAction($id)
  {
    try {
      Permission::find($id)->delete();
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
