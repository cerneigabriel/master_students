<?php

namespace MasterStudents\Controllers\Admin;

use Collections\Pair;
use MasterStudents\Core\View;
use MasterStudents\Models\User;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;
use MasterStudents\Models\Role;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return View::view("admin.users.index", [
            "users" => User::all()
        ])->render();
    }

    public function create(Request $request)
    {
        return View::view("admin.users.create")->render();
    }

    public function edit(Request $request, array $params)
    {
        $user = User::find($params["id"])->withRelations(["roles", "sessions"]);

        if (is_null($user)) return response()->redirect(url("error", ["code" => 417]));

        return View::view("admin.users.edit", [
            "model" => map($user->toArray()),
            "roles" => Role::all()
        ])->render();
    }

    public function store(Request $request)
    {
        $user = User::createAction($request->all()->toArray());

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->created) return response()->handleErrorWithView($user->validator, $request, "admin.users.create");

        Session::set("success", "User successfully created");

        return response()->redirect(url("admin.users.index"));
    }

    public function update(Request $request, $params)
    {
        $user = User::updateAction($request->all()->toArray(), $params["id"], "adminUpdateRules");

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->updated) return response()->handleErrorWithView(
            $user->validator,
            $request,
            "admin.users.edit",
            User::find($params["id"])->withRelations(["roles", "sessions"]),
            [
                "roles" => Role::all()
            ]
        );

        Session::set("success", "User successfully updated");

        return response()->redirect(url("admin.users.index"));
    }

    public function delete(Request $request, $params)
    {
        $user = User::deleteAction($request->all()->toArray(), $params["id"]);

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->updated) {
            Session::set("success", "User wasn't deleted. Something went wrong");

            return response()->handleErrorWithView($user->validator, $request, "admin.users.index");
        }

        Session::set("success", "User successfully deleted");

        return response()->redirect(url("admin.users.index"));
    }

    public function detachRole(Request $request, array $params)
    {
        $user = User::find($params["user_id"]);
        $role = Role::find($params["role_id"]);

        $user->detachRole($role);

        Session::set("success", "Role detached from $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    public function detachRoles(Request $request, array $params)
    {
        $user = User::find($params["user_id"]);

        foreach ($request->get("roles") ?? [] as $role_id) {
            $role = Role::find($role_id);
            $user->detachRole($role);
        }

        Session::set("success", "Roles detached from $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    public function attachRole(Request $request, array $params)
    {
        $user = User::find($params["user_id"]);
        $role = Role::find($params["role_id"]);

        $user->attachRole($role);

        Session::set("success", "Role was attached to $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    public function attachRoles(Request $request, array $params)
    {
        $user = User::find($params["user_id"]);

        $user->detachAllRoles();

        foreach ($request->get("roles") ?? [] as $role_id) {
            $role = Role::find($role_id);
            $user->attachRole($role);
        }

        Session::set("success", "Roles were attached to $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }
}
