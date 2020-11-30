<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Models\Role;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;
use MasterStudents\Models\Permission;

class RolesController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_admin_panel", "view_admin_roles"];

    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "roles";

    /**
     * Index page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $this->runHandler();

        return View::view("admin.roles.index", [
            "roles" => Role::all()
        ])->render();
    }

    /**
     * Create new role page
     *
     * @param Request $quest
     * @return void
     */
    public function create(Request $quest)
    {
        $this->runHandler(["create_admin_roles"]);

        return View::view("admin.roles.create")->render();
    }

    /**
     * Edit role page
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function edit(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_roles"]);

        $role = Role::find($params["id"])->withRelations(["permissions"]);

        if (is_null($role)) return response()->redirect(url("error", ["code" => 404]));

        return View::view("admin.roles.edit", [
            "model" => map($role->toArray()),
            "permissions" => Permission::all()
        ])->render();
    }

    /**
     * Store new role
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->runHandler(["create_admin_roles"]);

        $role = Role::createAction($request->all()->toArray());

        if ($role->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$role->created) return response()->handleErrorWithView($role->validator, $request, "admin.roles.create");

        Session::set("success", "Role successfully created");

        return response()->redirect(url("admin.roles.index"));
    }

    /**
     * Update Role
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function update(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_roles"]);

        $role = Role::updateAction($request->all()->toArray(), $params["id"]);

        if ($role->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$role->updated) return response()->handleErrorWithView($role->validator, $request, "admin.roles.edit", Role::find($params["id"])->withRelations(["permissions"]));

        Session::set("success", "Role successfully updated");

        return response()->redirect(url("admin.roles.index"));
    }

    /**
     * Delete role
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function delete(Request $request, array $params)
    {
        $this->runHandler(["delete_admin_roles"]);

        $role = Role::deleteAction($params["id"]);

        if ($role->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$role->deleted) {
            Session::set("success", "Role wasn't deleted. Something went wrong");

            return response()->redirect("admin.roles.index");
        }

        Session::set("success", "Role successfully deleted");

        return response()->redirect(url("admin.roles.index"));
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
        $this->runHandler(["detach_permission_admin_roles"]);

        $role = Role::find($params["role_id"]);
        $permission = Permission::find($params["permission_id"]);

        $role->detachPermission($permission);

        Session::set("success", "Permission detached from $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
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
        $this->runHandler(["detach_permission_admin_roles"]);

        $role = Role::find($params["role_id"]);
        $permissions = map($request->get("permissions") ?? [])->map(fn ($id) => Permission::find($id))->filter(fn ($v) => !is_null($v));

        $role->detachPermissions($permissions);

        Session::set("success", "Permissions detached from $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
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
        $this->runHandler(["attach_permission_admin_roles"]);

        $role = Role::find($params["role_id"]);
        $permission = Permission::find($params["permission_id"]);

        $role->attachPermission($permission);

        Session::set("success", "Permission was attached to $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
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
        $this->runHandler(["attach_permission_admin_roles"]);

        $role = Role::find($params["role_id"]);
        $permissions = map($request->get("permissions") ?? [])->map(fn ($id) => Permission::find($id))->filter(fn ($v) => !is_null($v));

        $role->attachPermissions($permissions);

        Session::set("success", "Permissions were attached to $role->name successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
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
        $this->runHandler(["attach_permission_admin_roles", "detach_permission_admin_roles"]);

        $role = Role::find($params["role_id"]);
        $permissions = map($request->get("permissions") ?? [])->map(fn ($id) => Permission::find($id))->filter(fn ($v) => !is_null($v));

        $role->updatePermissions($permissions);

        Session::set("success", "Permissions for {$role->name} were updated successfully");

        return response()->redirect(url("admin.roles.edit", ["id" => $role->id]));
    }
}
