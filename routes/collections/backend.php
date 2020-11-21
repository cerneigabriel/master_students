<?php

use MasterStudents\Controllers\Admin\AdminController;


/**
 * 
 * Back-End Routes
 */
router()->get("/admin", [
    "controller" => "AdminController::index",
    "name" => "admin",
    "middleware" => [
        AuthMiddleware::class,
        SuperAdminMiddleware::class
    ]
]);
