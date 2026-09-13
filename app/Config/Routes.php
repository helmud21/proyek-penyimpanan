<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/about', 'About::index');
$routes->get('/dashboard', 'Dashboard::index');


$routes->post('/login', 'Login::login');
