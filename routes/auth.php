<?php

/**
 * 
 * Auth Routes
 */

$app->router->get("/auth/login", array("controller" => "Auth\AuthController::login", "name" => "auth.login"));
$app->router->post("/auth/login", array("controller" => "Auth\AuthController::loginAttempt", "name" => "auth.login"));
$app->router->get("/auth/register", array("controller" => "Auth\AuthController::register", "name" => "auth.register"));
$app->router->post("/auth/register", array("controller" => "Auth\AuthController::registerAttempt", "name" => "auth.register"));
$app->router->post("/auth/logout", array("controller" => "Auth\AuthController::logoutAttempt", "name" => "auth.logout"));
