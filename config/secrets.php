<?php

return [
    "clients" => [
        "default" => [
            "id" => "1",
            "secret" => 'secret',
            "scopes" => "login graphql",
            "name" => "Default client",
            "location" => "1,2"
        ],
    ],
    "users" => [
        "test@example.com" => [
            "id" => "1",
            "name" => "Test user",
            "password" => 'secret',
            "client_id" => "default"
        ],
    ],
    "scopes" => [
        "login" => "Login scope",
        "graphql" => "Access to the GraphQL endpoints"
    ]
];
