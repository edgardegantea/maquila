<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'UserController::login');

$routes->get('registro', 'RegistroController::new');
$routes->post('registro', 'RegistroController::create');

$routes->get('password/request-reset', 'ResetPassword::requestReset');
$routes->post('password/send-reset-link', 'ResetPassword::sendResetLink');
$routes->get('password/reset/(:any)', 'ResetPassword::reset/$1');

$routes->post('password/update-password', 'ResetPassword::updatePassword');
$routes->match(['get', 'post'], 'login', 'UserController::login', ["filter" => "noauth"]);
$routes->resource('usuarios', ['controller' => 'Admin\UsuarioController']);

// Rutas para el 
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin\AdminController::index');
    
});


$routes->get('logout', 'UserController::logout');