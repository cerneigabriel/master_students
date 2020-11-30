<?php

namespace MasterStudents\Middlewares;

use Carbon\Carbon;
use Closure;
use MasterStudents\Core\Auth;
use MasterStudents\Core\Config;
use MasterStudents\Core\Request;
use MasterStudents\Core\Session;

class SessionsCheckerMiddleware
{
  public function handle(Request $request)
  {
    if (Auth::check()) {
      $user_session = Auth::user_session();

      if (!$user_session->remember_token && Carbon::parse($user_session->updated_at)->diffInMinutes(Carbon::now()) > Config::get("session.timeout")) {

        Auth::logoutAttempt();

        Session::set("warning", "Your session expired. Login again and enjoy the process.");

        return response()->redirect(url("auth.login"));
      }
    }

    return true;
  }
}
