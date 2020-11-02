<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Request;
use MasterStudents\Core\View;

class Router
{
    protected Request $request;
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            return "Not found";
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        echo call_user_func($callback);
    }

    public function renderView($view)
    {
        return View::view($view)->render();
    }
}
