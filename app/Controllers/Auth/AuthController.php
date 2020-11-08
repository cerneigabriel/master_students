<?php

namespace MasterStudents\Controllers\Auth;

use Rakit\Validation\Validator;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

// Models
use MasterStudents\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return View::view("frontend.auth.login")->render();
    }

    public function loginAttempt(Request $request)
    {
        return $request->all()->toArray();
    }

    public function register(Request $request)
    {
        return View::view("frontend.auth.register")->render();
    }

    public function registerAttempt(Request $request)
    {
        $validator = $request->validate(User::rules());
        $request = $request->all();

        if ($validator->fails()) {
            return View::view("frontend.auth.register", [
                "errors" => $validator->errors(),
                "model" => $request
            ])->render();
        }



        $user = new User();
        $user->first_name = $request->get("first_name");
        $user->last_name = $request->get("last_name");
        $user->email = $request->get("email");
        $user->password = $request->get("password");
        $user->birthdate = $request->get("birthdate");
        $user->phone = $request->get("phone");
        $user->company = $request->get("company");
        $user->speciality = $request->get("speciality");
        $user->gender = $request->get("gender");
        $user->notes = $request->get("notes");

        var_dump($user);
        die();

        return $user;
    }

    public function logoutAttempt(Request $request)
    {
        return $request->all()->toArray();
    }
}
