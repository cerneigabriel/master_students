<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Application;
use MasterStudents\Core\Controller;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

class ContactController extends Controller
{
    /**
     * Index Page
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return View::view("frontend.contact")->render();
    }

    /**
     * Contact Attempt Method
     *
     * @param Request $request
     * @return void
     */
    public function send(Request $request)
    {
        return "Form submited";
    }
}
