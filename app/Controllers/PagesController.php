<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\View;

class PagesController
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
