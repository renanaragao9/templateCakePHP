<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $routes) {
        $routes->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);
        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->prefix('Api', function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);
        $routes->connect('/auth/login', ['controller' => 'Auth', 'action' => 'login']);
        $routes->connect('/auth/register', ['controller' => 'Auth', 'action' => 'register']);
        $routes->connect('/auth/logout', ['controller' => 'Auth', 'action' => 'logout']);
        $routes->connect('/auth/fetch-users', ['controller' => 'Auth', 'action' => 'fetchUsers']);
        $routes->fallbacks(DashedRoute::class);
    });
};
