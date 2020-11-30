<?php

use MasterStudents\Middlewares\AuthMiddleware;
use MasterStudents\Middlewares\SuperAdminMiddleware;


function getAdminRouteDetails(string $controller, string $name, array $middlewares = [])
{
    return [
        "controller" => $controller,
        "name" => $name,
        "middlewares" => [
            AuthMiddleware::class
        ] + $middlewares
    ];
}


/**
 * Admin Routes
 */
router()->get("/admin", getAdminRouteDetails("Admin\AdminController::index", "admin.index"));


// Users Management Routes
require_once ROUTES_PATH . "collections/admin/users.php";

// Roles Management Routes
require_once ROUTES_PATH . "collections/admin/roles.php";

// Permissions Management Routes
require_once ROUTES_PATH . "collections/admin/permissions.php";

// Groups Management Routes
require_once ROUTES_PATH . "collections/admin/groups.php";
