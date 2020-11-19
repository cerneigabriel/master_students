<?php

/**
 * 
 * Auth Routes
 */

router()->get("/auth/login", array("controller" => "Auth\AuthController::login", "name" => "auth.login"));
router()->post("/auth/login", array("controller" => "Auth\AuthController::loginAttempt", "name" => "auth.login"));
router()->get("/auth/register", array("controller" => "Auth\AuthController::register", "name" => "auth.register"));
router()->post("/auth/register", array("controller" => "Auth\AuthController::registerAttempt", "name" => "auth.register"));
router()->post("/auth/logout", array("controller" => "Auth\AuthController::logoutAttempt", "name" => "auth.logout"));
