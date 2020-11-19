<?php

use Spiral\Database\Driver\MySQL\MySQLDriver;

return [
    "dsn" => env("DB_DSN"),
    "dbname" => env("DB_DATABASE"),
    "user" => env("DB_USERNAME"),
    "password" => env("DB_PASSWORD"),
    "host" => env("DB_HOST"),
    "driver" => env("DB_DRIVER"),
    "port" => env("DB_PORT"),


    "credentials" => [
        "default"   => "default",
        "databases" => [
            "default" => ["driver" => "mysql"],
        ],
        "drivers"   => [
            "mysql"     => [
                "driver"     => MySQLDriver::class,
                "options"    => [
                    "connection" => env("DB_DSN"),
                    "username"   => env("DB_USERNAME"),
                    "password"   => env("DB_PASSWORD"),
                ]
            ],
        ]
    ]
];
