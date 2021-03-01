<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan// directories.
$routes->get('/', 'Home::index');
$routes->match(['get', 'post'], '/register', 'Auth::register_view', ['filter' => 'noauth']);
$routes->match(['get', 'post'], '/login', 'Auth::login_view', ['filter' => 'noauth']);
$routes->match(['get', 'post'], '/recovery', 'Auth::recovery_view', ['filter' => 'noauth']);
$routes->get('profile', 'Profile::profile', ['filter' => 'auth']);
//$routes->get('profile/cities', 'Profile::cities', ['filter' => 'auth']);

// Admin login
$routes->match(['get', 'post'], '/admin/login', 'Admin\Auth::login_view', ['filter' => 'noauth']);

// Cities
$routes->get('profile/cities', 'Admin\City::index', ['filter' => 'auth']);
$routes->get('profile/cities/(:any)', 'Admin\City::item_view/$1', ['filter' => 'auth']);
$routes->get('profile/cities/(:any)/(:any)', 'Admin\City::item_view/$1/$2', ['filter' => 'auth']);

// Users - clients
$routes->get('profile/users', 'Admin\Users::index', ['filter' => 'auth']);
$routes->get('profile/users/(:any)', 'Admin\Users::item_view/$1', ['filter' => 'auth']);
$routes->get('profile/users/(:any)/(:any)', 'Admin\Users::item_view/$1/$2', ['filter' => 'auth']);

// Users - admin/operators
$routes->get('profile/users-main', 'Admin\UsersAdmin::index', ['filter' => 'auth']);
$routes->get('profile/users-main/(:any)', 'Admin\UsersAdmin::item_view/$1', ['filter' => 'auth']);
$routes->get('profile/users-main/(:any)/(:any)', 'Admin\UsersAdmin::item_view/$1/$2', ['filter' => 'auth']);

// Client 
$routes->get('profile/address', 'Client\Address::index', ['filter' => 'auth']);
$routes->get('profile/address/(:any)', 'Client\Address::item_view/$1', ['filter' => 'auth']);
$routes->get('profile/address/(:any)/(:any)', 'Client\Address::item_view/$1/$2', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
