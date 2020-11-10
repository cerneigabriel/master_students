<?php

use MasterStudents\Core\Application;
use MasterStudents\Core\Config;

function server($key = null)
{
    return is_null($key) ? $_SERVER : (isset($_SERVER[$key]) ? $_SERVER[$key] : false);
}

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
    if (server("HTTP_X_FORWARDED_PROTO") === false) $protocol = 'https://';
    else $protocol = 'http://';

    $host = server("HTTP_HOST");
    return "$protocol$host";
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