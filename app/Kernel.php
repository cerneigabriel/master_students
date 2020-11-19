<?php

namespace MasterStudents;

use MasterStudents\Middlewares\CSRFMiddleware;

class Kernel
{
    protected $middlewares = [
        "csrf" => CSRFMiddleware::class
    ];

    protected $defaultMiddlewares = [
        CSRFMiddleware::class
    ];

    public function runDefault()
    {
        $this->runMiddlewares($this->defaultMiddlewares);
    }

    public function runMiddlewares($middlewares)
    {
        foreach ($middlewares as $middleware) {
            if ((new $middleware)->handle(request())) {
                continue;
            } else {
                return response()->redirect(url("error.401"));
            }
        }
    }
}
