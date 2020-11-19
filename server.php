<?php

define("BASE_PATH", __DIR__ . "/");
define("APP_PATH", BASE_PATH . "app/");
define("VENDOR_PATH", BASE_PATH . "vendor/");
define("ROUTES_PATH", BASE_PATH . "routes/");
define("VIEWS_PATH", BASE_PATH . "resources/views/");
define("LAYOUTS_PATH", VIEWS_PATH . "layouts/");
define("CONFIG_PATH", BASE_PATH . "config/");
define("DATABASE_PATH", BASE_PATH . "database/");
define("MIGRATIONS_PATH", BASE_PATH . "database/migrations/");


require_once VENDOR_PATH . "autoload.php";

use MasterStudents\Core\Application;

$app = new Application(BASE_PATH);


if (!isset($run_migrations))
    $app->run();