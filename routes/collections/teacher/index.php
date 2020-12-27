<?php


use MasterStudents\Middlewares\AuthMiddleware;

global $teacher_route_directory;
global $teacher_prefix;
global $teacher_namespace;
global $teacher_name;

$teacher_route_directory = ROUTES_PATH . "collections/teacher/";
$teacher_prefix = "/teacher";
$teacher_namespace = "Teacher\\";
$teacher_name = "teacher.";

function getTeacherRouteDetails(string $controller, string $name, array $middlewares = [])
{
  return [
    "controller" => $GLOBALS["teacher_namespace"] . $controller,
    "name" => $GLOBALS["teacher_name"] . $name,
    "middlewares" => [
      AuthMiddleware::class
    ] + $middlewares
  ];
}


/**
 * Teacher Routes
 */
router()->get($teacher_prefix, getTeacherRouteDetails("TeacherController::index", "index"));


// // Users Management Routes
// require_once "{$teacher_route_directory}users.php";
