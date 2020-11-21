<?php

namespace MasterStudents\Controllers\Admin;

use Collections\Map;
use MasterStudents\Core\Auth;
use MasterStudents\Core\Hash;
use MasterStudents\Core\View;
use MasterStudents\Models\User;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return View::view("backend.index")->render();
    }

    public function loginAttempt(Request $request)
    {
        // $validator = $request->validate(User::loginRules());
        // $request = $request->all();

        // if ($validator->fails()) {
        //     return View::view("frontend.auth.login", [
        //         "errors" => $validator->errors(),
        //         "model" => $request
        //     ])->render();
        // }

        // $user = User::query(fn ($query) => ($query->where("email", $request->get("email"))))->first();

        // if (auth()->attempt($user, $request->get("password"))) {
        //     session()->set("success", "You are logged in.");

        //     return response()->redirect(url("profile.index"));
        // }

        // session()->set("error", "Email or password does not match our records.");

        // return View::view("frontend.auth.login", [
        //     "errors" => $validator->errors(),
        //     "model" => $request
        // ])->render();
    }
}
