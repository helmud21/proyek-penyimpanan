<?php

use App\Controllers\BarangController;
use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index', ['filter' => 'logout']);
$routes->get('/about', 'About::index');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => ['auth', 'role:admin']]);
$routes->get('/dashboard/ceo', 'Dashboard::ceo', ['filter' => ['auth', 'role:ceo']]);
$routes->get('/barang/data', 'BarangController::index', ['filter' => 'auth']);
$routes->get('/barang/(:num)', 'BarangController::getBarang/$1', ['filter' => ['auth', 'role:admin']]);
$routes->get('/logout', 'Dashboard::logout');

$routes->post('/login', 'Login::login');
$routes->post('/barang/create', 'BarangController::create', ['filter' => 'auth']);
$routes->post('/barang/ubah/(:num)', 'BarangController::ubahData/$1', ['filter' => ['auth', 'role:admin']]);
$routes->delete('/barang/(:num)', 'BarangController::hapusBarang/$1', ['filter' => ['auth', 'role:admin']]);
