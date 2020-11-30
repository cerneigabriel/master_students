<?php

namespace MasterStudents\Controllers\Admin;

use MasterStudents\Core\View;
use MasterStudents\Core\Request;
use MasterStudents\Core\Controller;

class AdminController extends Controller
{
    /**
     * Define default permissions for controller
     *
     * @var array
     */
    protected $defaultHandlers = ["view_admin_panel"];

    /**
     * Index page | Dashboard Page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $this->runHandler(["view_admin_dashboard"]);

        return View::view("admin.index")->render();
    }
}
