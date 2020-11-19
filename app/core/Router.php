<?php

namespace MasterStudents\Core;


use MasterStudents\Core\Application;
use MasterStudents\Core\Response;
use MasterStudents\Core\Request;
use MasterStudents\Core\Route;
use MasterStudents\Core\View;
use Collections\Vector;
use MasterStudents\Kernel;

class Router
{
    protected Request $request;
    protected Response $response;
    protected Vector $routes;
    public Route $current_route;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->routes = new Vector();
    }

    public function get(string $path, array $details)
    {
        $this->routes->add(new Route($path, $details, "get"));
    }

    public function post(string $path, array $details)
    {
        $this->routes->add(new Route($path, $details, "post"));
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $route = $this->find($path, $method);

        if (!$route) $route = $this->find(null, null, "error.404");

        $this->current_route = $route;

        switch ($this->request->getMethod()) {
            case "post":
                (new Kernel)->runDefault();
                break;
        }

        if (!empty($route->middlewares)) {
            (new Kernel)->runMiddlewares($route->middlewares);
        }

        return call_user_func($route->callback, $this->request);
    }

    public function find($path, $method = null, $name = null)
    {
        $routes = $this->routes;

        if (!is_null($path))
            $routes = $routes->filter(fn ($route) => ($route->path == $path));

        if (!is_null($method))
            $routes = $routes->filter(fn ($route) => ($route->method == $method));

        if (!is_null($name))
            $routes = $routes->filter(fn ($route) => ($route->name == $name));

        return $routes->first();
    }
}
