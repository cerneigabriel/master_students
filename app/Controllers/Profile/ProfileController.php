<?php

namespace MasterStudents\Controllers\Profile;

use Collections\Map;
use MasterStudents\Core\Auth;
use MasterStudents\Core\Hash;
use MasterStudents\Core\View;
use MasterStudents\Models\User;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Traits\DatabaseManagerTrait;

class ProfileController extends Controller
{
    protected $table = "users";

    public function index(Request $request)
    {
        return View::view("master_student.profile.dashboard", [
            "user" => auth()->user()
        ])->render();
    }
}
