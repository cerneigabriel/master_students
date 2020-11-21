<?php

namespace MasterStudents\Core;

use Dotenv\Dotenv;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Request $request;
    public Response $response;
    public Router $router;
    public Database $database;
    public Migrations $migrations;
    public Session $session;
    public Hash $hash;

    public function __construct($rootPath, $run_migrations = false)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->initiateDotenv()
            ->initiateHelpers()
            ->setDefaultTimeZone("Europe/Chisinau");


        $this->database = new Database();
        $this->migrations = new Migrations();
        if (!$run_migrations) {
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router($this->request, $this->response);
            $this->session = new Session();
            $this->hash = new Hash();
            $this->auth = new Auth();


            $this->initiateWebRoutes();
        }

        return $this;
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function initiateDotenv()
    {
        Dotenv::createImmutable(BASE_PATH)->load();
        return $this;
    }

    public function initiateHelpers()
    {
        require_once APP_PATH . "helpers.php";
        return $this;
    }

    public function initiateWebRoutes()
    {
        require_once ROUTES_PATH . "web.php";
        return $this;
    }

    public function setDefaultTimeZone(string $timezone)
    {
        date_default_timezone_set($timezone);
        return $this;
    }
}
