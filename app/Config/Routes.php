<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('news/(:segment)', 'Home::news/$1');
$routes->get('category/(:segment)', 'Home::category/$1');
$routes->get('search', 'Home::search');
$routes->post('load-more', 'Home::loadMore');
$routes->post('newsletter', 'Home::newsletter');

// Authentication Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::forgotPassword');
    $routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
    $routes->post('reset-password/(:segment)', 'Auth::resetPassword/$1');
    $routes->get('logout', 'Auth::logout');
    $routes->get('check-remember', 'Auth::checkRememberToken');
});

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('profile', 'Admin::profile');
    $routes->post('profile', 'Admin::profile');
    
    // News Routes
    $routes->group('news', function($routes) {
        $routes->get('/', 'News::index');
        $routes->get('create', 'News::create');
        $routes->post('create', 'News::create');
        $routes->get('edit/(:num)', 'News::edit/$1');
        $routes->post('edit/(:num)', 'News::edit/$1');
        $routes->get('delete/(:num)', 'News::delete/$1');
        $routes->get('submit/(:num)', 'News::submit/$1');
        $routes->get('pending', 'News::pending');
        $routes->get('approve/(:num)', 'News::approve/$1');
        $routes->get('reject/(:num)', 'News::reject/$1');
        $routes->post('upload-image', 'News::uploadImage');
    });
    
    // Categories Routes
    $routes->group('categories', function($routes) {
        $routes->get('/', 'Categories::index');
        $routes->get('create', 'Categories::create');
        $routes->post('create', 'Categories::create');
        $routes->get('edit/(:num)', 'Categories::edit/$1');
        $routes->post('edit/(:num)', 'Categories::edit/$1');
        $routes->get('delete/(:num)', 'Categories::delete/$1');
        $routes->get('toggle/(:num)', 'Categories::toggle/$1');
    });
    
    // Users Routes (Admin only)
    $routes->group('users', function($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('create', 'Users::create');
        $routes->post('create', 'Users::create');
        $routes->get('edit/(:num)', 'Users::edit/$1');
        $routes->post('edit/(:num)', 'Users::edit/$1');
        $routes->get('delete/(:num)', 'Users::delete/$1');
        $routes->get('toggle-status/(:num)', 'Users::toggleStatus/$1');
    });
});
