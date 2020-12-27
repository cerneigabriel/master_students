<?php

namespace MasterStudents\Controllers\Leader;

use MasterStudents\Core\Auth;
use MasterStudents\Core\View;

// Models
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;

class LeaderController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_leader_panel"];
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
        $this->runHandler(["view_leader_dashboard"]);

        return View::view("leader.index")->render();
    }
}
