<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $routes) {

        # Authenticated routes
        $routes->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);
        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $routes->connect('/reset-password', ['controller' => 'Auth', 'action' => 'resetPassword']);
        $routes->connect('/change-password/*', ['controller' => 'Auth', 'action' => 'changePassword']);

        # Users routes
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        $routes->connect('/user/visualizar/:id', ['controller' => 'Users', 'action' => 'view'], ['pass' => ['id'], 'id' => '\d+']);

        # Fallback route
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->prefix('Api', function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);

        # Authenticated routes
        $routes->connect('/auth/login', ['controller' => 'Auth', 'action' => 'login']);
        $routes->connect('/auth/register', ['controller' => 'Auth', 'action' => 'register']);
        $routes->connect('/auth/logout', ['controller' => 'Auth', 'action' => 'logout']);
        $routes->fallbacks(DashedRoute::class);

        # users routes API
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'fetchUsers', 'method' => 'GET']);
        $routes->connect('/user/:id', ['controller' => 'Users', 'action' => 'fetchUser', 'method' => 'GET'], ['pass' => ['id'], 'id' => '\d+']);
        $routes->connect('/user-add', ['controller' => 'Users', 'action' => 'addUser', 'method' => 'POST']);
        $routes->connect('/user-edit/:id', ['controller' => 'Users', 'action' => 'editUser', 'method' => ['PUT', 'PATCH']], ['pass' => ['id'], 'id' => '\d+']);
        $routes->connect('/user-delete/:id', ['controller' => 'Users', 'action' => 'deleteUser', 'method' => 'DELETE'], ['pass' => ['id'], 'id' => '\d+']);
    });
};
