<?php

namespace MasterStudents\Controllers;

use MasterStudents\Core\View;

class ErrorsController
{
    protected $views = [
        "404" => "frontend.errors.404",
        "401" => "frontend.errors.401",
        "400" => "frontend.errors.400",
        "200" => "frontend.errors.200",
        "201" => "frontend.errors.201",
    ];

    public function handle404()
    {
        response()->setStatusCode(404);
        return View::view($this->views["404"])->render();
    }
}
