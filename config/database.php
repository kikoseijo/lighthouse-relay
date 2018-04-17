<?php

$return = [
    "default" => "api",
    "migrations" => "migrations",
    "fetch" => PDO::FETCH_CLASS,
    "connections" => [
        "api" => [
            "driver" => "mysql",
            "host"      => env("DB_HOST", "localhost"),
            "port"      => env("DB_PORT", 3306),
            "database"  => env("DB_DATABASE", "local_api"),
            "username"  => env("DB_USERNAME", "api"),
            "password"  => env("DB_PASSWORD", 'secret'),
            "charset"   => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix"    => "",
            // "timezone"  => env("APP_TIMEZONE", "Europe/Brussels"),
        ],
        "api_testing" => [
            "driver" => "mysql",
            "host"      => env("DB_HOST", "localhost"),
            "port"      => env("DB_PORT", 3306),
            "database"  => env("DB_DATABASE", "local_api_test"),
            "username"  => env("DB_USERNAME", "api_test"),
            "password"  => env("DB_PASSWORD", 'secret'),
            "charset"   => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix"    => "",
            // "timezone"  => env("APP_TIMEZONE", "Europe/Brussels"),
        ],
    ],
    "redis" => [
        "cluster" => false,
        "default" => [
            "host"     => env("REDIS_HOST", "127.0.0.1"),
            "port"     => env("REDIS_PORT", 6379),
            "database" => 0,
        ],
    ],
];

return $return;
