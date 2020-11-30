<?php

namespace MasterStudents\Controllers\Profile;

use MasterStudents\Core\Auth;
use MasterStudents\Core\View;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;

class ProfileController extends Controller
{
    /**
     * Specify table name for repository initializer
     *
     * @var string
     */
    protected $table = "users";

    /**
     * Index Page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return View::view("master_student.profile.dashboard", [
            "user" => Auth::user()
        ])->render();
    }
}
