<?php

/**
 * Admin Routes
 */

use MasterStudents\Middlewares\AuthMiddleware;
use MasterStudents\Middlewares\SuperAdminMiddleware;

$middlewares = [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
];

router()->get("/admin", [
    "controller" => "Admin\AdminController::index",
    "name" => "admin.index",
    "middlewares" => $middlewares
]);

require_once ROUTES_PATH . "collections/admin/users.php";
require_once ROUTES_PATH . "collections/admin/roles.php";
require_once ROUTES_PATH . "collections/admin/permissions.php";
