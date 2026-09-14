<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index', ['filter' => 'logout']);
$routes->get('/about', 'About::index');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => ['auth', 'role:admin']]);
$routes->get('/dashboard/ceo', 'Dashboard::ceo', ['filter' => ['auth', 'role:ceo']]);
$routes->get('/logout', 'Dashboard::logout');


$routes->post('/login', 'Login::login');
