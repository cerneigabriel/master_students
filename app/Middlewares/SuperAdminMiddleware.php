<?php

namespace MasterStudents\Middlewares;

use MasterStudents\Core\Auth;
use MasterStudents\Core\Request;
use MasterStudents\Models\User;

class SuperAdminMiddleware
{
    public function handle(Request $request)
    {
        if (Auth::user()->hasRoleKey("super_admin"))
            return true;

        return response()->redirect(url("home"));
    }
}
