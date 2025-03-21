<?php

return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'Security' => [
        'salt' => env('SECURITY_SALT', 'ae1e6a702a9b4f97a5bc13dc337b839fda35b43bf011770a4eff4c9fc45528b9'),
    ],

    'App' => [
        'name' => 'Template',
        'slogan' => 'O melhor template de Fortaleza',
        'logo' => '/webroot/img/logo.png',
        'defaultLocale' => 'pt_BR',
        'defaultTimezone' => 'America/Sao_Paulo',
    ],

    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'renan',
            'password' => 'Renan@12',
            'database' => 'cake',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ],
    ],

    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => 'smtp.mailtrap.io',
            'port' => 2525,
            'username' => 'ccf434307d88b0',
            'password' => 'ac1b80b9c5ac60',
            'tls' => false,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => 'template@example.com',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ],
    ],

    'ApiKey' => env('API_KEY', '0e1d6226-2f53-4949-9737-f1c260647ed1'),
];
