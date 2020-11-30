<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Models\Permission;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;

class PermissionsController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_admin_panel", "view_admin_permissions"];

    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "permissions";

    /**
     * Index page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $this->runHandler();

        return View::view("admin.permissions.index", [
            "permissions" => Permission::all()
        ])->render();
    }

    /**
     * Create new Permission page
     *
     * @param Request $quest
     * @return void
     */
    public function create(Request $quest)
    {
        $this->runHandler(["create_admin_permissions"]);

        return View::view("admin.permissions.create")->render();
    }

    /**
     * Edit permission page
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function edit(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_permissions"]);

        $permission = Permission::find($params["id"]);

        if (is_null($permission)) return response()->redirect(url("error", ["code" => 404]));

        return View::view("admin.permissions.edit", [
            "model" => map($permission->toArray())
        ])->render();
    }

    /**
     * Store new permission
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->runHandler(["create_admin_permissions"]);

        $permission = Permission::createAction($request->all()->toArray());

        if ($permission->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$permission->created) return response()->handleErrorWithView($permission->validator, $request, "admin.permissions.create");

        Session::set("success", "Permission successfully created");

        return response()->redirect(url("admin.permissions.index"));
    }

    /**
     * Update Permission
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function update(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_permissions"]);

        $permission = Permission::updateAction($request->all()->toArray(), $params["id"]);

        if ($permission->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$permission->updated) return response()->handleErrorWithView($permission->validator, $request, "admin.permissions.edit");

        Session::set("success", "Permission successfully updated");

        return response()->redirect(url("admin.permissions.index"));
    }

    /**
     * Delete Permission
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function delete(Request $request, array $params)
    {
        $this->runHandler(["delete_admin_permissions"]);

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
