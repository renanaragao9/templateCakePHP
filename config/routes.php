<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);
    $routes->connect('/academy-config/toggle-dark-mode', ['controller' => 'AcademyConfig', 'action' => 'toggleDarkMode']);

    $routes->scope('/', function (RouteBuilder $routes) {
        $routes->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);

        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);

        $routes->fallbacks(DashedRoute::class);
    });
};
