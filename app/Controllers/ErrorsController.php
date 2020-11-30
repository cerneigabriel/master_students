<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Controller;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

class ErrorsController extends Controller
{
    /**
     * Handle Errors In application
     *
     * @param Request $request
     * @param array $params
     * @return void
     */
    public function handle(Request $request, array $params)
    {
        response()->setStatusCode($params["code"]);
        return View::view("frontend.errors.{$params["code"]}")->render();
    }
}
