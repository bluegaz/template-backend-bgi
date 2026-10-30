<?php

use App\Controllers\LoginController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', [LoginController::class, 'index']);

$routes->group('login', static function (RouteCollection $routes): void {
    $routes->post('auth', [LoginController::class, 'auth']);
    $routes->post('second-auth', [LoginController::class, 'secondAuth']);
});

