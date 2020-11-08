<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Response;
use MasterStudents\Core\Request;
use MasterStudents\Core\Router;
use MasterStudents\Core\Config;
use Dotenv\Dotenv;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Router $router;
    public Request $request;
    public Response $response;
    public Config $config;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        if (env("APP_ENV") === "production") Dotenv::createImmutable(BASE_PATH . "../")->load();
        else Dotenv::createImmutable(BASE_PATH)->load();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
