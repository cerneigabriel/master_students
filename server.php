<?php

define("BASE_PATH", realpath(dirname(__FILE__)) . "/");
define("APP_PATH", BASE_PATH . "app/");
define("VENDOR_PATH", BASE_PATH . "vendor/");
define("ROUTES_PATH", BASE_PATH . "routes/");
define("VIEWS_PATH", BASE_PATH . "resources/views/");
define("LAYOUTS_PATH", VIEWS_PATH . "layouts/");
define("CONFIG_PATH", BASE_PATH . "config/");
define("DATABASE_PATH", BASE_PATH . "database/");
define("MIGRATIONS_PATH", BASE_PATH . "database/migrations/");


require_once VENDOR_PATH . "autoload.php";

var_dump([
    BASE_PATH,
    APP_PATH,
    VENDOR_PATH,
    ROUTES_PATH,
    VIEWS_PATH,
    LAYOUTS_PATH,
    CONFIG_PATH,
    DATABASE_PATH,
    MIGRATIONS_PATH,
]);

// use MasterStudents\Core\Application;

// $app = new Application(BASE_PATH, $run_migrations ?? false);

// if (!isset($run_migrations))
//     $app->run();
