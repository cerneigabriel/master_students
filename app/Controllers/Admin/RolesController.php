<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Models\Role;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;
use MasterStudents\Models\Permission;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        return View::view("admin.roles.index", [
            "roles" => Role::all()
        ])->render();
    }

    public function create(Request $quest)
    {
        return View::view("admin.roles.create")->render();
    }

    public function edit(Request $request, array $params)
    {
        $role = Role::find($params["id"])->withRelations(["permissions"]);

        if (is_null($role)) return response()->redirect(url("error", ["code" => 404]));

        return View::view("admin.roles.edit", [
            "model" => map($role->toArray()),
            "permissions" => Permission::all()
        ])->render();
    }

    public function store(Request $request)
    {
        $role = Role::createAction($request->all()->toArray());

        if ($role->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$role->created) return response()->handleErrorWithView($role->validator, $request, "admin.roles.create");

        Session::set("success", "Role successfully created");

        return response()->redirect(url("admin.roles.index"));
    }

    public function update(Request $request, array $params)
    {
        $role = Role::updateAction($request->all()->toArray(), $params["id"]);

        if ($role->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$role->updated) return response()->handleErrorWithView($role->validator, $request, "admin.roles.edit", Role::find($params["id"])->withRelations(["permissions"]));

        Session::set("success", "Role successfully updated");

        return response()->redirect(url("admin.roles.index"));
    }

    public function delete(Request $request, array $params)
    {
        $role = Role::deleteAction($params["id"]);

        if ($role->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$role->deleted) {
            Session::set("success", "Role wasn't deleted. Something went wrong");

            return response()->redirect("admin.roles.index");
        }

        Session::set("success", "Role successfully deleted");

        return response()->redirect(url("admin.roles.index"));
    }

    public function detachPermission(Request $request, array $params)
    {
        $role = Role::find($params["role_id"]);
        $permission = Permission::find($params["permission_id"]);

        $role->detachPermission($permission);

        Session::set("success", "Permission detached from $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
    }

    public function detachPermissions(Request $request, array $params)
    {
        $role = Role::find($params["role_id"]);

        foreach ($request->get("permissions") ?? [] as $permission_id) {
            $permission = Role::find($permission_id);
            $role->detachPermission($permission);
        }

        Session::set("success", "Permissions detached from $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
    }

    public function attachPermission(Request $request, array $params)
    {
        $role = Role::find($params["role_id"]);
        $permission = Permission::find($params["permission_id"]);

        $role->attachPermission($permission);

        Session::set("success", "Permission was attached to $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
    }

    public function attachPermissions(Request $request, array $params)
    {
        $role = Role::find($params["role_id"]);

        $role->detachAllPermissions();

        foreach ($request->get("permissions") ?? [] as $permission_id) {
            $permission = Permission::find($permission_id);
            $role->attachPermission($permission);
        }

        Session::set("success", "Roles were attached to $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
    }
}
