<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman awal langsung ke login
$routes->get('/', 'Auth::index');

// Auth (tidak perlu login untuk akses ini)
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Semua route di bawah ini WAJIB login (pakai filter 'auth')
$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('dashboard', 'Dashboard::index');

    // CRUD Pasien
    $routes->get('pasien', 'Pasien::index');
    $routes->get('pasien/create', 'Pasien::create');
    $routes->post('pasien/store', 'Pasien::store');
    $routes->get('pasien/edit/(:num)', 'Pasien::edit/$1');
    $routes->post('pasien/update/(:num)', 'Pasien::update/$1');
    $routes->get('pasien/delete/(:num)', 'Pasien::delete/$1');

    // CRUD Dokter
    $routes->get('dokter', 'Dokter::index');
    $routes->get('dokter/create', 'Dokter::create');
    $routes->post('dokter/store', 'Dokter::store');
    $routes->get('dokter/edit/(:num)', 'Dokter::edit/$1');
    $routes->post('dokter/update/(:num)', 'Dokter::update/$1');
    $routes->get('dokter/delete/(:num)', 'Dokter::delete/$1');

    // CRUD Poli
    $routes->get('poli', 'Poli::index');
    $routes->get('poli/create', 'Poli::create');
    $routes->post('poli/store', 'Poli::store');
    $routes->get('poli/edit/(:num)', 'Poli::edit/$1');
    $routes->post('poli/update/(:num)', 'Poli::update/$1');
    $routes->get('poli/delete/(:num)', 'Poli::delete/$1');

    // CRUD Pendaftaran
    $routes->get('pendaftaran', 'Pendaftaran::index');
    $routes->get('pendaftaran/create', 'Pendaftaran::create');
    $routes->post('pendaftaran/store', 'Pendaftaran::store');
    $routes->get('pendaftaran/edit/(:num)', 'Pendaftaran::edit/$1');
    $routes->post('pendaftaran/update/(:num)', 'Pendaftaran::update/$1');
    $routes->get('pendaftaran/delete/(:num)', 'Pendaftaran::delete/$1');

    // Laporan
    $routes->get('laporan', 'Laporan::index');

    $routes->get('profil', 'Profil::index');
    $routes->post('profil/update', 'Profil::update');
    $routes->post('profil/update-password', 'Profil::updatePassword');

});
