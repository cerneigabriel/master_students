<?php

namespace MasterStudents\Controllers\Auth;

use Collections\Map;
use MasterStudents\Core\Auth;
use MasterStudents\Core\Hash;
use MasterStudents\Core\View;
use MasterStudents\Models\User;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Session;
use MasterStudents\Core\Traits\DatabaseManagerTrait;

class AuthController extends Controller
{
    protected $table = "users";

    public function login(Request $request)
    {
        return View::view("frontend.auth.login")->render();
    }

    public function loginAttempt(Request $request)
    {
        $validator = $request->validate(User::loginRules());

        if ($validator->fails()) return $this->handleErrorWithView($validator, $request, "frontend.auth.login");

        $remember_me = filter_var($request->get("remember_me", false), FILTER_VALIDATE_BOOLEAN);

        if (Auth::loginAttempt($request->get("email"), $request->get("password"), $remember_me)) {
            Session::set("success", "You are logged in.");

            return response()->redirect(url("profile.index"));
        }

        Session::set("error", "Email or password does not match our records.");

        return View::view("frontend.auth.login", [
            "errors" => $validator->errors(),
            "model" => $request
        ])->render();
    }

    public function register(Request $request)
    {
        return View::view("frontend.auth.register")->render();
    }

    public function registerAttempt(Request $request)
    {
        $validator = $request->validate(User::registrationRules());

        if ($validator->fails()) return $this->handleErrorWithView($validator, $request, "auth.register");

        User::create([
            "username" => $request->get("username"),
            "first_name" => $request->get("first_name"),
            "last_name" => $request->get("last_name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password")),
        ]);

        return response()->redirect(url("auth.login"));
    }

    public function logoutAttempt(Request $request)
    {
        if (Auth::logoutAttempt()) {
            Session::set("success", "You are logged out successfuly.");

            return response()->redirect(url("auth.login"));
        }

        return response()->redirect(url("error.500"));
    }

    public function checkUsername(Request $request)
    {
        $usernameRule = [map(User::rules())->get("username")];

        $validator = $request->validate($usernameRule);

        if ($validator->fails()) return $this->handleErrorWithJSON($validator, 401);

        return response()->json([
            "status" => 200,
            "errors" => []
        ], 200);
    }
}
