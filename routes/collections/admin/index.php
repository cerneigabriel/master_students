<?php

use MasterStudents\Middlewares\AuthMiddleware;

global $admin_route_directory;
global $admin_prefix;
global $admin_namespace;
global $admin_name;

$admin_route_directory = ROUTES_PATH . "collections/admin/";
$admin_prefix = "/admin";
$admin_namespace = "Admin\\";
$admin_name = "admin.";

function getAdminRouteDetails(string $controller, string $name, array $middlewares = [])
{
    return [
        "controller" => $GLOBALS["admin_namespace"] . $controller,
        "name" => $GLOBALS["admin_name"] . $name,
        "middlewares" => [
            AuthMiddleware::class
        ] + $middlewares
    ];
}


/**
 * Admin Routes
 */
router()->get($admin_prefix, getAdminRouteDetails("AdminController::index", "index"));


// Users Management Routes
require_once "{$admin_route_directory}users.php";

// Roles Management Routes
require_once "{$admin_route_directory}roles.php";

// Permissions Management Routes
require_once "{$admin_route_directory}permissions.php";

// Groups Management Routes
require_once "{$admin_route_directory}groups.php";
