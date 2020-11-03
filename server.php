<?php

define("BASE_PATH", "/");
define("APP_PATH", BASE_PATH . "app/");
define("VENDOR_PATH", BASE_PATH . "vendor/");
define("ROUTES_PATH", BASE_PATH . "routes/");
define("VIEWS_PATH", BASE_PATH . "resources/views/");
define("LAYOUTS_PATH", VIEWS_PATH . "layouts/");
define("CONFIG_PATH", BASE_PATH . "config/");


// echo $_SERVER;
require_once VENDOR_PATH . "autoload.php";
require_once APP_PATH . "helpers.php";

var_dump(BASE_PATH);

use MasterStudents\Core\Application;

$app = new Application();

require_once ROUTES_PATH . "web.php";

$app->run();