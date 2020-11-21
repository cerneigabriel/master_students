<?php

use Collections\Map;
use MasterStudents\Core\Application;
use MasterStudents\Core\Config;

function app()
{
    return Application::$app;
}

function database()
{
    return app()->database;
}

function auth()
{
    return app()->auth;
}

function session()
{
    return app()->session;
}

function scheduler()
{
    return app()->scheduler;
}

function router()
{
    return app()->router;
}

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
    if (server("HTTP_X_FORWARDED_PROTO") === false) $protocol = server("REQUEST_SCHEME") . '://';
    else $protocol = server("HTTP_X_FORWARDED_PROTO") . '://';

    $host = server("HTTP_HOST");
    return "$protocol$host";
}

function url(string $details)
{
    $route = app()->router->find($details);
    if (is_null($route)) $route = app()->router->find(null, null, $details);

    return baseUrl() . $route->path;
}

function assets(string $path)
{
    if (str_split($path)[0] !== "/") $path = "/$path";
    return baseUrl() . $path;
}

function response()
{
    return app()->response;
}

function request()
{
    return app()->request;
}

function map($items = [])
{
    return new Map($items);
}
