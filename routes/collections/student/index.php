<?php


use MasterStudents\Middlewares\AuthMiddleware;

global $student_route_directory;
global $student_prefix;
global $student_namespace;
global $student_name;

$student_route_directory = ROUTES_PATH . "collections/student/";
$student_prefix = "/student";
$student_namespace = "Student\\";
$student_name = "student.";

function getStudentRouteDetails(string $controller, string $name, array $middlewares = [])
{
    return [
        "controller" => $GLOBALS["student_namespace"] . $controller,
        "name" => $GLOBALS["student_name"] . $name,
        "middlewares" => [
            AuthMiddleware::class
        ] + $middlewares
    ];
}


/**
 * Student Routes
 */
router()->get($student_prefix, getStudentRouteDetails("StudentController::index", "index"));


// // Users Management Routes
// require_once "{$student_route_directory}users.php";
