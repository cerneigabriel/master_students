<?php

use Collections\Map;
use Collections\Vector;
use MasterStudents\Core\Application;
use MasterStudents\Core\Config;
use MasterStudents\Core\Session;

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

function env($prop = null)
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

function url(string $details, array $params = array())
{
    $route = router()->find($details);
    if (is_null($route)) $route = router()->find(null, null, $details);

    if (!is_null($route)) {
        $path = $route->path;

        if (count($route->parameters) > 0) {
            if (count($route->parameters) !== count($params)) url("error", ["code" => 417]);
            foreach ($params as $key => $value) $path = str_replace("{{$key}}", "$value", $path);
        }
    } else $path = "";


    return baseUrl() . $path;
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

function vector($items = [])
{
    return new Vector($items);
}

function csrf_meta()
{
    return "<meta name=\"_token\" content=\"" . Session::get("_token") . "\">";
}

function csrf_input()
{
    return "<input type=\"hidden\" name=\"_token\" value=\"" . Session::get("_token") . "\">";
}

