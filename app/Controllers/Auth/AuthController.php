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

class AuthController extends Controller
{
    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "users";

    /**
     * Login Page
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        return View::view("frontend.auth.login")->render();
    }

    /**
     * Register Page
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        return View::view("frontend.auth.register")->render();
    }

    /**
     * Login Attempt Method
     *
     * @param Request $request
     * @return void
     */
    public function loginAttempt(Request $request)
    {
        $validator = $request->validate(User::loginRules());

        if ($validator->fails()) return response()->handleErrorWithView($validator, $request, "frontend.auth.login");

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

    /**
     * Register Attempt Method
     *
     * @param Request $request
     * @return void
     */
    public function registerAttempt(Request $request)
    {
        $user = User::createAction($request->all()->toArray());

        if ($user->server_error) return response()->redirect(url("error", ["code" => 500]));
        if (!$user->created) return response()->handleErrorWithView($user->validator, $request, "frontend.auth.register");

        Session::set("success", "You have successfully registered");

        return response()->redirect(url("auth.login"));
    }

    /**
     * Logout Attempt Method
     *
     * @param Request $request
     * @return void
     */
    public function logoutAttempt(Request $request)
    {
        if (Auth::logoutAttempt()) {
            Session::set("success", "You are logged out successfuly.");

            return response()->redirect(url("auth.login"));
        }

        return response()->redirect(url("error", [
            "code" => 404
        ]));
    }

    /**
     * Check Username for correctness
     *
     * @param Request $request
     * @return void
     */
    public function checkUsername(Request $request)
    {
        $usernameRule = [map(User::rules())->get("username")];

        $validator = $request->validate($usernameRule);

        if ($validator->fails()) return response()->handleErrorWithJSON($validator, 401);

        return response()->json([
            "status" => 200,
            "errors" => []
        ], 200);
    }
}
