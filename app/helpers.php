<?php

use MasterStudents\Core\Application;
use MasterStudents\Core\Config;

function env($prop)
{
    return $_ENV[$prop] ?? false;
}

function config($prop)
{
    return Config::get($prop);
}

function baseUrl()
{
    return $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"];
}

function url(string $details)
{
    $route = Application::$app->router->find($details);
    if (is_null($route)) $route = Application::$app->router->find(null, null, $details);

    return baseUrl() . $route->path;
}

function assets(string $path)
{
    if (str_split($path)[0] !== "/") $path = "/$path";
    return baseUrl() . $path;
}

function router()
{
    return Application::$app->router;
}

function response()
{
    return Application::$app->response;
}