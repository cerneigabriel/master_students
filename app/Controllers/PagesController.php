<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Controller;
use MasterStudents\Core\View;

class PagesController extends Controller
{
    public function index()
    {
        return View::view("frontend.index")->render();
    }

    public function about()
    {
        return View::view("frontend.about")->render();
    }
}
