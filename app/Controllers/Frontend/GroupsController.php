<?php

namespace MasterStudents\Controllers\Frontend;

use MasterStudents\Core\Auth;
use MasterStudents\Core\Config;
use MasterStudents\Core\View;
use MasterStudents\Models\Group;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Mail;
use MasterStudents\Core\Session;
use MasterStudents\Models\GroupUser;
use MasterStudents\Models\GroupUserStatus;
use MasterStudents\Models\Speciality;
use MasterStudents\Models\User;
use MasterStudents\Models\UserStatus;
use PHPMailer\PHPMailer\Exception;
use stdClass;

class GroupsController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = [];

    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "groups";


    public function inviteAccept(Request $request, array $params) {
        $group_user = GroupUser::query(fn ($q) => $q->where("group_id", $params["group_id"])->where("token", $params["token"]))->first();

        if (is_null($group_user)) {
            return response()->redirect(url("error", ["code" => 404]));
        }
        
        $group_user_status_active = GroupUserStatus::query(fn ($q) => $q->where("key", "active"))->first();

        $user_status = UserStatus::query(fn ($q) => $q->where("key", "active"))->first();
        
        $user = User::find($group_user->user_id);
        

        Auth::loginAttemptByUser($user);


        $group_user->update([
            "group_user_status_id" => $group_user_status_active->id,
            "token" => null
        ]);

        $user->update(["user_status_id" => $user_status->id]);

        
        $role = map($user->roles())->first();

        return response()->redirect(url("{$role->key}.index"));
    }
    
    public function inviteDecline(Request $request, array $params) {
        $group_user = GroupUser::query(fn ($q) => $q->where("group_id", $params["group_id"])->where("token", $params["token"]))->first();

        if (is_null($group_user)) {
            return response()->redirect(url("error", ["code" => 404]));
        }
        
        $group_user_status_declined = GroupUserStatus::query(fn ($q) => $q->where("key", "declined"))->first();


        $group_user->update([
            "group_user_status_id" => $group_user_status_declined->id,
            "token" => null
        ]);

        return response()->redirect(url("auth.login"));
    }
}
