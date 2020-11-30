<?php

namespace MasterStudents\Actions;

use MasterStudents\Models\Group;
use MasterStudents\Models\Permission;

trait GroupsActions
{
  public static function createAction(array $data)
  {
    $validator = request()->validate(Group::registrationRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "created" => false,
      "validator" => $validator
    ];

    try {
      $group = Group::create($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "created" => true,
      "group" => $group
    ];
  }

  public static function updateAction(array $data, $id)
  {
    $validator = request()->validate(Group::updateRules());

    if ($validator->fails()) return (object) [
      "server_error" => false,
      "updated" => false,
      "validator" => $validator
    ];

    try {
      $group = Group::find($id)->update($data);
    } catch (\Exception $e) {
      return (object) [
        "server_error" => true
      ];
    }

    return (object) [
      "server_error" => false,
      "updated" => true,
      "group" => $group
    ];
  }

  public static function deleteAction($id)
  {
    try {
      Group::find($id)->delete();
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
