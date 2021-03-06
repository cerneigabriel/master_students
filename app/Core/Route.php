<?php

namespace MasterStudents\Core;

use Exception;

class Route
{
    public $name = null;
    public $controller = null;
    public $controller_method = null;
    public $method = null;
    public $path = null;
    public $callback = null;
    public $middlewares = [];
    public $parameters = [];

    public function __construct(string $path, array $details, string $method)
    {
        $this->http_host = server("HTTP_HOST");
        $this->request_scheme = server("REQUEST_SCHEME");

        $this->setMethod($method);
        $this->setPath($path);

        if (isset($details["controller"])) $this->setController($details["controller"]);
        if (isset($details["name"])) $this->setName($details["name"]);
        if (isset($details["middlewares"])) $this->setMiddlewares($details["middlewares"]);

        return $this;
    }

    private function setController($controller)
    {
        if (is_string($controller) && str_contains($controller, "::") && count(explode("::", $controller)) === 2) {
            $this->controller = "\\MasterStudents\\Controllers\\" . explode("::", $controller)[0];
            $this->controller = new $this->controller;
            $this->controller_method = explode("::", $controller)[1];

            $controller = [$this->controller, $this->controller_method];
        }

        $this->callback = $controller;

        if (!is_callable($this->callback)) {
            throw new Exception("$controller not found. Check controller name or method for correctness.");
        }

        return $this;
    }

    private function setPath($path)
    {
        if ($path[0] !== "/") $path = "/$path";
        if (count(str_split($path)) < 1) throw new Exception("Invalid path");

        $this->parameters = map(explode("/", $path))
            ->filter(fn ($v) => $v != "" && str_contains($v, "{") && str_contains($v, "}"))
            ->toArray();

        $this->path = $path;

        return $this;
    }

    private function setName($name)
    {
        if (!isset($name)) throw new Exception("Name must be specified");

        $this->name = $name;

        return $this;
    }

    private function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    private function setMiddlewares($middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function url()
    {
        return url($this->name);
    }

    public function getExplodedRoutePathWithParams()
    {
        return map(explode("/", $this->path))->filter(fn ($v) => $v != "");
    }

    public function getExplodedRoutePathWithoutParams()
    {
        return $this->getExplodedRoutePathWithParams()->filter(fn ($v) => $v != "" && !in_array($v, $this->parameters));
    }
}
