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
            'username' => 'seu_username',
            'password' => 'seu_password',
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
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    'ApiKey' => env('API_KEY', 'sua_chave_api'),
];
