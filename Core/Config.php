<?php

namespace MasterStudents\Core;

class Config
{
    private static string $DEFAULT_DIRECTORY = CONFIG_PATH;
    private static string $DEFAULT_EXTENSION = ".php";

    public static function get($path)
    {
        $path = explode(".", $path);
        $filename = self::$DEFAULT_DIRECTORY . $path[0] . self::$DEFAULT_EXTENSION;

        $config = include($filename);

        foreach (array_slice($path, 1, count($path) - 1) as $i) {
            $config = $config[$i];
        }

        return $config;
    }
}
