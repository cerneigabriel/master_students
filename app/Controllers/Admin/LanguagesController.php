<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Models\User;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;
use MasterStudents\Models\Permission;
use MasterStudents\Models\Role;

class LanguagesController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_admin_panel", "view_admin_languages"];

    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "users";

    /**
     * Index page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $this->runHandler();

        return View::view("admin.users.index", [
            "users" => User::all()
        ])->render();
    }

    /**
     * Create new user controller method
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $this->runHandler(["create_admin_users"]);

        return View::view("admin.users.create")->render();
    }

    /**
     * Edit user controller method
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function edit(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_users"]);

        $user = User::find($params["id"])->withRelations(["roles", "sessions"]);

        if (is_null($user)) return response()->redirect(url("error", ["code" => 417]));

        return View::view("admin.users.edit", [
            "model" => map($user->toArray()),
            "roles" => Role::all(),
            "permissions" => map(Permission::all())->filter(fn ($v) => !in_array($v->id, map($user->rolesPermissions())->map(fn ($v) => $v->id)->toArray()))->toArray()
        ])->render();
    }

    /**
     * Store new user
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->runHandler(["create_admin_users"]);

        $user = User::createAction($request->all()->toArray());

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->created) return response()->handleErrorWithView($user->validator, $request, "admin.users.create");

        Session::set("success", "User successfully created");

        return response()->redirect(url("admin.users.index"));
    }

    /**
     * Change User Password
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function changePassword(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_users"]);

        $user = User::changePasswordAction($request->all()->toArray(), $params["id"]);

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->updated) {
            return response()->handleErrorWithView(
                $user->validator,
                $request,
                "admin.users.edit",
                User::find($params["id"])->withRelations(["roles", "sessions"]),
                [
                    "roles" => Role::all()
                ]
            );
        }

        Session::set("success", "User successfully updated");

        return response()->redirect(url("admin.users.edit", ["id" => $params["id"]]));
    }

    /**
     * Update user
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function update(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_users"]);

        var_dump($request->all()->toArray());
        die();

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

    /**
     * Delete user
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function delete(Request $request, array $params)
    {
        $this->runHandler(["delete_admin_users"]);

        $user = User::deleteAction($params["id"]);

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->deleted) {
            Session::set("success", "User wasn't deleted. Something went wrong");

            return response()->handleErrorWithView(null, $request, "admin.users.index");
        }

        Session::set("success", "User successfully deleted");

        return response()->redirect(url("admin.users.index"));
    }

    /**
     * Detach Role
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function detachRole(Request $request, array $params)
    {
        $this->runHandler(["detach_role_admin_users"]);

        $user = User::find($params["user_id"]);
        $role = Role::find($params["role_id"]);

        $user->detachRole($role);

        Session::set("success", "Role was detached from $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Detach Roles
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function detachRoles(Request $request, array $params)
    {
        $this->runHandler(["detach_role_admin_users"]);

        $user = User::find($params["user_id"]);
        $roles = map($request->get("roles") ?? [])->map(fn ($id) => Role::find($id))->filter(fn ($v) => !is_null($v));

        $user->detachRoles($roles);

        Session::set("success", "Roles were detached from $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Attach Role
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function attachRole(Request $request, array $params)
    {
        $this->runHandler(["attach_role_admin_users"]);

        $user = User::find($params["user_id"]);
        $role = Role::find($params["role_id"]);

        $user->attachRole($role);

        Session::set("success", "Role was attached to $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Attach Roles
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function attachRoles(Request $request, array $params)
    {
        $this->runHandler(["attach_role_admin_users"]);

        $user = User::find($params["user_id"]);
        $roles = map($request->get("roles") ?? [])->map(fn ($id) => Role::find($id))->filter(fn ($v) => !is_null($v));

        $user->attachRoles($roles);

        Session::set("success", "Roles were attached to $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Update Roles
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function updateRoles(Request $request, array $params)
    {
        $this->runHandler(["detach_role_admin_users", "attach_role_admin_users"]);

        $user = User::find($params["user_id"]);
        $roles = map($request->get("roles") ?? [])->map(fn ($id) => Role::find($id))->filter(fn ($v) => !is_null($v));

        $user->updateRoles($roles);

        Session::set("success", "Roles for $user->first_name $user->last_name were updated successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Detach Permission
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function detachPermission(Request $request, array $params)
    {
        $this->runHandler(["detach_permission_admin_users"]);

        $user = User::find($params["user_id"]);
        $permission = Permission::find($params["permission_id"]);

        $user->detachPermission($permission);

        Session::set("success", "Permission was detached from $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Detach Permissions
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function detachPermissions(Request $request, array $params)
    {
        $this->runHandler(["detach_permission_admin_users"]);

        $user = User::find($params["user_id"]);
        $permissions = map($request->get("permissions") ?? [])->map(fn ($id) => Permission::find($id))->filter(fn ($v) => !is_null($v));

        $user->detachPermissions($permissions);

        Session::set("success", "Permissions were detached from $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Attach Permission
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function attachPermission(Request $request, array $params)
    {
        $this->runHandler(["attach_permission_admin_users"]);

        $user = User::find($params["user_id"]);
        $permission = Permission::find($params["permission_id"]);

        $user->attachPermission($permission);

        Session::set("success", "Permission was attached to $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Attach Permissions
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function attachPermissions(Request $request, array $params)
    {
        $this->runHandler(["attach_permission_admin_users"]);

        $user = User::find($params["user_id"]);
        $permissions = map($request->get("permissions") ?? [])->map(fn ($id) => Permission::find($id))->filter(fn ($v) => !is_null($v));

        $user->attachPermissions($permissions);

        Session::set("success", "Roles were attached to $user->first_name $user->last_name successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }

    /**
     * Update Permissions
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function updatePermissions(Request $request, array $params)
    {
        $this->runHandler(["detach_permission_admin_users", "attach_permission_admin_users"]);

        $user = User::find($params["user_id"]);
        $permissions = map($request->get("permissions") ?? [])->map(fn ($id) => Permission::find($id))->filter(fn ($v) => !is_null($v));

        $user->updatePermissions($permissions);

        Session::set("success", "Permissions for $user->first_name $user->last_name were updated successfully");

        return response()->redirect(url("admin.users.edit", ["id" => $user->id]));
    }
}
