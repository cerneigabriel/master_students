<?php

namespace MasterStudents\Middlewares;

use MasterStudents\Core\Auth;
use MasterStudents\Core\Request;
use MasterStudents\Models\User;

class SuperAdminMiddleware
{
    public function handle(Request $request)
    {
        if ($this->isSuperAdmin(Auth::user()))
            return true;

        return response()->redirect(url("home"));
    }

    private function isSuperAdmin(User $user)
    {
        return map($user->roles())
            ->map(fn ($value) => ($value->key))
            ->filter(fn ($key) => ($key === "super_admin"))
            ->count() > 0;
    }
}
