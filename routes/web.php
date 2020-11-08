<?php

/**
 * 
 * Web Routes
 */

require_once ROUTES_PATH . "auth.php";
require_once ROUTES_PATH . "errors.php";

$app->router->get("/", array("controller" => "PagesController::index", "name" => "home"));
$app->router->get("/about", array("controller" => "PagesController::about", "name" => "about"));

$app->router->get("/contact", array("controller" => "ContactController::index", "name" => "contact.index"));
$app->router->post("/contact", array("controller" => "ContactController::send", "name" => "contact.send"));
