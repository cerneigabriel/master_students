<?php

namespace MasterStudents\Controllers\Teacher;

use MasterStudents\Core\Auth;
use MasterStudents\Core\View;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;

class TeacherController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_teacher_panel"];
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
        $this->runHandler(["view_teacher_dashboard"]);

        return View::view("teacher.index")->render();
    }
}
