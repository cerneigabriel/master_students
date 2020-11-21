<?php

namespace MasterStudents;

use MasterStudents\Core\Request;
use MasterStudents\Middlewares\CSRFMiddleware;
use MasterStudents\Middlewares\SessionsCheckerMiddleware;

class Kernel
{
    protected $defaultMiddlewares = [
        CSRFMiddleware::class
    ];

    protected $webDefault = [
        SessionsCheckerMiddleware::class
    ];

    public function runDefault(Request $request)
    {
        $this->runMiddlewares($request, $this->defaultMiddlewares);
    }

    public function runWebDefault(Request $request)
    {
        $this->runMiddlewares($request, $this->webDefault);
    }

    public function runMiddlewares(Request $request, $middlewares)
    {
        for ($index = 0; $index < count($middlewares); $index++) {
            $middleware = $middlewares[$index];
            $middleware = new $middleware();

            $runNext = false;

            $runNext = $middleware->handle($request);

            if ($runNext === true) continue;
            else break;
        }
    }
}
