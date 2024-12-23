<?php
return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'Security' => [
        'salt' => env('SECURITY_SALT', 'ae1e6a702a9b4f97a5bc13dc337b839fda35b43bf011770a4eff4c9fc45528b9'),
    ],

    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'renan',
            'password' => 'Renan@12',
            'database' => 'aslafit',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ],
    ],

    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
