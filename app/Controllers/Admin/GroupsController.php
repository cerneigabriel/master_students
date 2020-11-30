<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Models\Group;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;
use MasterStudents\Models\User;

class GroupsController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_admin_panel", "view_admin_groups"];

    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "groups";

    /**
     * Index page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $this->runHandler();

        return View::view("admin.groups.index", [
            "groups" => Group::all()
        ])->render();
    }

    /**
     * Create new group page
     *
     * @param Request $quest
     * @return void
     */
    public function create(Request $quest)
    {
        $this->runHandler(["create_admin_groups"]);

        return View::view("admin.groups.create", [
            "users" => map(User::all())->filter(fn ($u) => $u->hasRoleKey("student"))->toArray()
        ])->render();
    }

    /**
     * Edit group page
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function edit(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_groups"]);

        $group = Group::find($params["id"])->withRelations(["users"]);

        if (is_null($group)) return response()->redirect(url("error", ["code" => 404]));

        return View::view("admin.groups.edit", [
            "model" => map($group->toArray()),
            "users" => map(User::all())->filter(fn ($u) => $u->hasRoleKey("student"))->toArray()
        ])->render();
    }

    /**
     * Store new group
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->runHandler(["create_admin_groups"]);

        $group = Group::createAction($request->all()->toArray());

        if ($group->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$group->created) return response()->handleErrorWithView($group->validator, $request, "admin.groups.create");

        Session::set("success", "Group successfully created");

        return response()->redirect(url("admin.groups.index"));
    }

    /**
     * Update group
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function update(Request $request, array $params)
    {
        $this->runHandler(["edit_admin_groups"]);

        $group = Group::updateAction($request->all()->toArray(), $params["id"]);

        if ($group->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$group->updated) return response()->handleErrorWithView($group->validator, $request, "admin.groups.edit");

        Session::set("success", "Group successfully updated");

        return response()->redirect(url("admin.groups.index"));
    }

    /**
     * Delete group
     *
     * @param Request $request
     * @param [type] $params
     * @return void
     */
    public function delete(Request $request, $params)
    {
        $this->runHandler(["delete_admin_groups"]);

        $group = Group::deleteAction($params["id"]);

        if ($group->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$group->deleted) {
            Session::set("success", "Group wasn't deleted. Something went wrong");

            return response()->redirect("admin.groups.index");
        }

        Session::set("success", "Group successfully deleted");

        return response()->redirect(url("admin.groups.index"));
    }

    /**
     * Detach User
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function detachUser(Request $request, array $params)
    {
        $this->runHandler(["detach_user_admin_groups"]);

        $group = Group::find($params["group_id"]);
        $group->detachUser(User::find($params["user_id"]));

        Session::set("success", "Student was detached from $group->name successfully");

        return response()->redirect(url("admin.groups.edit", ["id" => $group->id]));
    }

    /**
     * Detach Users
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function detachUsers(Request $request, array $params)
    {
        $this->runHandler(["detach_user_admin_groups"]);

        $group = Group::find($params["group_id"]);
        $users = map($request->get("users") ?? [])->map(fn ($id) => User::find($id))->filter(fn ($v) => !is_null($v));

        $group->detachUsers($users);

        Session::set("success", "Students were detached from $group->name successfully");

        return response()->redirect(url("admin.groups.edit", ["id" => $group->id]));
    }

    /**
     * Attach User
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function attachUser(Request $request, array $params)
    {
        $this->runHandler(["attach_user_admin_groups"]);

        $group = Group::find($params["group_id"]);
        $user = User::find($params["user_id"]);

        $group->attachUser($user);

        Session::set("success", "Student was attached to $group->name successfully");

        return response()->redirect(url("admin.groups.edit", ["id" => $group->id]));
    }

    /**
     * Attach Users
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function attachUsers(Request $request, array $params)
    {
        $this->runHandler(["attach_user_admin_groups"]);

        $group = Group::find($params["group_id"]);
        $users = map($request->get("users") ?? [])->map(fn ($id) => User::find($id))->filter(fn ($v) => !is_null($v));

        $group->attachUsers($users);

        Session::set("success", "Students were attached to $group->name successfully");

        return response()->redirect(url("admin.groups.edit", ["id" => $group->id]));
    }

    /**
     * Update Users
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function updateUsers(Request $request, array $params)
    {
        $this->runHandler(["attach_user_admin_groups", "detach_user_admin_groups"]);

        $group = Group::find($params["group_id"]);
        $users = map($request->get("users") ?? [])->map(fn ($id) => User::find($id))->filter(fn ($v) => !is_null($v));

        $group->updateUsers($users);

        Session::set("success", "Students for {$group->name} were updated successfully");

        return response()->redirect(url("admin.groups.edit", ["id" => $group->id]));
    }
}
