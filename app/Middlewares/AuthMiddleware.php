<?php

namespace MasterStudents\Middlewares;

use MasterStudents\Core\Request;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        if (auth()->check() && !is_null(session()->getAuthenticatedSession()) && session()->getAuthenticatedSession()["active"] == true)
            return true;

        return false;
    }
}
