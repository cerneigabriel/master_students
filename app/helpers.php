<?php

use MasterStudents\Core\Config;

function env($prop)
{
    return $_ENV[$prop] ?? false;
}

function config($prop)
{
    return Config::get($prop);
}
