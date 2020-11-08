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

function url(string $path)
{
    return Application::$app->router->find($path);
}

function router()
{
    return Application::$app->router;
}

function response()
{
    return Application::$app->response;
}