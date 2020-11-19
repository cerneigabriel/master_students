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

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->initiateDotenv();
        $this->initiateHelpers();
        $this->setDefaultTimeZone("Europe/Chisinau");


        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->database = new Database();
        $this->migrations = new Migrations();
        $this->session = new Session();
        $this->hash = new Hash();
        $this->auth = new Auth();


        $this->initiateWebRoutes();

        return $this;
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function initiateDotenv()
    {
        Dotenv::createImmutable(BASE_PATH)->load();
    }

    public function initiateHelpers()
    {
        require_once APP_PATH . "helpers.php";
    }

    public function initiateWebRoutes()
    {
        require_once ROUTES_PATH . "web.php";
    }

    public function setDefaultTimeZone(string $timezone)
    {
        date_default_timezone_set($timezone);
    }
}
