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
        $request = $request->all();

        if ($validator->fails()) {
            return View::view("frontend.auth.login", [
                "errors" => $validator->errors(),
                "model" => $request
            ])->render();
        }

        $user = User::query(fn ($query) => ($query->where("email", $request->get("email"))))->first();

        if (auth()->attempt($user, $request->get("password"))) {
            session()->set("success", "You are logged in.");

            return response()->redirect(url("profile.index"));
        }

        session()->set("error", "Email or password does not match our records.");

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
        $request = $request->all();

        if ($validator->fails()) {
            return View::view("frontend.auth.register", [
                "errors" => $validator->errors(),
                "model" => $request
            ])->render();
        }

        $user = User::create([
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
        auth()->logout();

        return response()->redirect(url("auth.login"));
    }

    public function checkUsername(Request $request)
    {
        $usernameRule = [(new Map(User::rules()))->get("username")];

        $validator = $request->validate($usernameRule);
        $request = $request->all();

        if ($validator->fails()) {
            return response()->json([
                "status" => 401,
                "errors" => $validator->errors(),
            ], 401);
        }

        return response()->json([
            "status" => 200,
            "errors" => []
        ], 200);
    }
}
