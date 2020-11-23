<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\Controller;
use MasterStudents\Core\Request;
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
        "417" => "frontend.errors.417"
    ];

    public function handle(Request $request, array $params)
    {
        if (in_array($params["code"], array_keys($this->views))) {
            response()->setStatusCode($params["code"]);
            return View::view($this->views[$params["code"]])->render();
        }
    }
}
