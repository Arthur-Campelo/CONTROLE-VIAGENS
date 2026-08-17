<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Authenticação de rotas automática pelo shield
service('auth')->routes($routes);

$routes->group('', ['filter' => 'session'], static function ($routes) {
    $routes->presenter('vehicles', ['controller' => 'VehicleController']);
    $routes->presenter('drivers', ['controller' => 'DriverController']);
    $routes->presenter('trips', ['controller' => 'TripController']);
});
