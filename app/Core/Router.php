<?php

namespace MasterStudents\Core;

use Collections\Pair;
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
    public static Vector $routes;
    public Route $current_route;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        static::$routes = new Vector([]);
    }

    public function get(string $path, array $details)
    {
        static::$routes->add(new Route($path, $details, "get"));
    }

    public function post(string $path, array $details)
    {
        static::$routes->add(new Route($path, $details, "post"));
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $route = $this->find($path, $method);
        $parameters = map();


        if (is_null($route)) {
            $parameters->add(new Pair("code", 404));
            $route = $this->find(null, null, "error");
        } elseif (count($route->parameters) > 0) {
            $route_path = $route->getExplodedRoutePathWithParams()->toArray();
            $current_path = map(explode("/", $path))->filter(fn ($v) => $v != "")->toArray();

            $keys = map(array_diff($route_path, $current_path))->map(fn ($k) => str_replace("{", "", str_replace("}", "", $k)));

            $i = 0;
            foreach ($keys->toArray() as $key) $parameters->add(new Pair($key, [...array_diff($current_path, $route_path)][$i++]));

            if ($parameters->count() !== count($route->parameters)) {
                $parameters->add(new Pair("code", 417));
                $route = $this->find(null, null, "error");
            }
        }

        $this->current_route = $route;
        $this->current_route->parametersValues = $parameters->toArray();

        if ($this->request->getMethod() === "get") (new Kernel)->runWebDefault($this->request);
        if ($this->request->getMethod() === "post") (new Kernel)->runDefault($this->request);

        if (!empty($route->middlewares)) {
            (new Kernel)->runMiddlewares($this->request, $route->middlewares);
        }

        return call_user_func($route->callback, $this->request, $this->current_route->parametersValues);
    }

    public function find($path, $method = null, $name = null)
    {
        $routes = static::$routes;

        if (!is_null($path))
            $routes = $routes->filter(function ($r) use ($path) {
                $route_path = $r->getExplodedRoutePathWithParams()->toArray();
                $route_path_without_params = $r->getExplodedRoutePathWithoutParams()->toArray();
                $current_path = map(explode("/", $path))->filter(fn ($v) => $v != "")->toArray();
                $is_valid = false;

                if (count($route_path) === count($current_path)) {
                    if (count($route_path) > 0) {
                        foreach ($route_path_without_params as $value) {
                            $is_valid = in_array($value, $current_path);
                            if (!$is_valid) return false;
                        }
                    } else $is_valid = true;
                }

                return $is_valid;
            });

        if (!is_null($method))
            $routes = $routes->filter(fn ($route) => ($route->method === $method));

        if (!is_null($name))
            $routes = $routes->filter(fn ($route) => ($route->name === $name));

        return $routes->first();
    }
}
