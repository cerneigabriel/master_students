<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Controller;
use MasterStudents\Core\View;

class ErrorsController extends Controller
{
    protected $views = [
        "404" => "frontend.errors.404",
        "401" => "frontend.errors.401",
        "400" => "frontend.errors.400",
        "200" => "frontend.errors.200",
        "201" => "frontend.errors.201",
        "500" => "frontend.errors.500",
    ];

    public function handle404()
    {
        response()->setStatusCode(404);
        return View::view($this->views["404"])->render();
    }

    public function handle500()
    {
        response()->setStatusCode(500);
        return View::view($this->views["500"])->render();
    }
}
