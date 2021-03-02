<?php

namespace MasterStudents\Controllers\Student;

use MasterStudents\Core\Auth;
use MasterStudents\Core\View;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;

class StudentController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_student_panel"];
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
        $this->runHandler(["view_student_dashboard"]);

        return View::view("student.index")->render();
    }
}
