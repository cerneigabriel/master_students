<?php

namespace MasterStudents\Middlewares;

use MasterStudents\Core\Request;

class CSRFMiddleware
{
    public function handle(Request $request)
    {
        if ($request->all()->get("session_id") === session()->get("session_id"))
            return true;

        return false;
    }
}
