<?php

namespace MasterStudents\Middlewares;

use Closure;
use MasterStudents\Core\Auth;
use MasterStudents\Core\Request;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        if (Auth::check())
            return true;

        return response()->redirect(url("auth.login"));
    }
}
