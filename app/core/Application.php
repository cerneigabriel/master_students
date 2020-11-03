<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Router;
use MasterStudents\Core\Request;
use MasterStudents\Core\Config;
use Dotenv\Dotenv;

class Application
{
    public Router $router;
    public Request $request;
    public Config $config;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);

        if (env("APP_ENV") === "production") Dotenv::createImmutable(BASE_PATH . "../")->load();
        else Dotenv::createImmutable(BASE_PATH)->load();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
