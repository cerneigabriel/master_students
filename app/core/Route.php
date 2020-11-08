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

    public function __construct(string $path, array $details, string $method)
    {
        $this->http_host = $_SERVER["HTTP_HOST"];
        $this->request_scheme = $_SERVER["REQUEST_SCHEME"];

        $this->setMethod($method);
        $this->setPath($path);

        if (isset($details["controller"])) $this->setController($details["controller"]);
        if (isset($details["name"])) $this->setName($details["name"]);

        return $this;
    }

    private function setController($controller)
    {
        if (!!strpos($controller, "::") && count(explode("::", $controller)) === 2) {
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
        $this->path = $path;
        // if (!!strpos($path, "{")) {
        //     var_dump(explode("{", $path));
        // }

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
}
