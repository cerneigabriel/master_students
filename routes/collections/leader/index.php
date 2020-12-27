<?php


use MasterStudents\Middlewares\AuthMiddleware;

global $leader_route_directory;
global $leader_prefix;
global $leader_namespace;
global $leader_name;

$leader_route_directory = ROUTES_PATH . "collections/leader/";
$leader_prefix = "/leader";
$leader_namespace = "Leader\\";
$leader_name = "leader.";

function getLeaderRouteDetails(string $controller, string $name, array $middlewares = [])
{
    return [
        "controller" => $GLOBALS["leader_namespace"] . $controller,
        "name" => $GLOBALS["leader_name"] . $name,
        "middlewares" => [
            AuthMiddleware::class
        ] + $middlewares
    ];
}


/**
 * Leader Routes
 */
router()->get($leader_prefix, getLeaderRouteDetails("LeaderController::index", "index"));


// // Users Management Routes
// require_once "{$leader_route_directory}users.php";
