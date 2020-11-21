<?php

/**
 * 
 * Auth Routes
 */

use MasterStudents\Middlewares\AuthMiddleware;

router()->get("/dashboard", array(
    "controller" => "Profile\ProfileController::index",
    "name" => "profile.index",
    "middlewares" => [
        AuthMiddleware::class
    ]
));
