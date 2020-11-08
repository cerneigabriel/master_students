<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Application;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

class ContactController extends Controller
{
    public function index()
    {
        return View::view("frontend.contact")->render();
    }

    public function send(Request $request)
    {
        var_dump($request->all()->toArray());
        return "Form submited";
    }
}
