<?php

use MasterStudents\Controllers\ContactController;
use MasterStudents\Core\Request;
use MasterStudents\Core\View;

$app->router->get("/", array("controller" => "PagesController::index", "name" => "home"));
$app->router->get("/about", array("controller" => "PagesController::about", "name" => "about"));

$app->router->get("/contact", array(
    "controller" => "ContactController::index",
    "name" => "contact.index"
));
$app->router->post("/contact", array("controller" => "ContactController::send", "name" => "contact.send"));

// Errors handlers
$app->router->get("/404", array("controller" => "ErrorsController::handle404", "name" => "error.404"));