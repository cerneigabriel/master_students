<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Models\Permission;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;

class PermissionsController extends Controller
{
    protected $table = "permissions";

    public function index(Request $request)
    {
        return View::view("admin.permissions.index", [
            "permissions" => Permission::all()
        ])->render();
    }

    public function create(Request $quest)
    {
        return View::view("admin.permissions.create")->render();
    }

    public function edit(Request $request, array $params)
    {
        $permission = Permission::find($params["id"]);

        if (is_null($permission)) return response()->redirect(url("error", ["code" => 404]));

        return View::view("admin.permissions.edit", [
            "model" => map($permission->toArray())
        ])->render();
    }

    public function store(Request $request)
    {
        $permission = Permission::createAction($request->all()->toArray());

        if ($permission->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$permission->created) return response()->handleErrorWithView($permission->validator, $request, "admin.permissions.create");

        Session::set("success", "Permission successfully created");

        return response()->redirect(url("admin.permissions.index"));
    }

    public function update(Request $request, array $params)
    {

        $permission = Permission::updateAction($request->all()->toArray(), $params["id"]);

        if ($permission->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$permission->updated) return response()->handleErrorWithView($permission->validator, $request, "admin.permissions.edit");

        Session::set("success", "Permission successfully updated");

        return response()->redirect(url("admin.permissions.index"));
    }

    public function delete(Request $request, $params)
    {
        $permission = Permission::deleteAction($params["id"]);

        if ($permission->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$permission->deleted) {
            Session::set("success", "Permission wasn't deleted. Something went wrong");

            return response()->redirect("admin.permissions.index");
        }

        Session::set("success", "Permission successfully deleted");

        return response()->redirect(url("admin.permissions.index"));
    }
}
