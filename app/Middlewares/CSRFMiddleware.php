<?php

namespace MasterStudents\Middlewares;

use Closure;
use MasterStudents\Core\Request;
use MasterStudents\Core\Session;

class CSRFMiddleware
{
    public function handle(Request $request)
    {
        if (is_null($request->get("_token")))
            return response()->redirect(url("home"));

        if ($request->get("_token") === Session::get("_token"))
            return true;

        return false;
    }
}
