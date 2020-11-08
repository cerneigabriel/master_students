<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Application;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

class ContactController
{
    public function index()
    {
        return View::view("frontend.contact")->render();
    }

    public function send(Request $request)
    {
        var_dump($request->all());
        return "Form submited";
    }
}
