<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Controller;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

class PagesController extends Controller
{
    /**
     * Index Page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return View::view("frontend.index")->render();
    }

    /**
     * About Page
     *
     * @param Request $request
     * @return void
     */
    public function about(Request $request)
    {
        return View::view("frontend.about")->render();
    }
}
