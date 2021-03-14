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
$routes->setDefaultMethod('index2');
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
$routes->get('/login', 'Auth::login_view', ['filter' => 'noauth']);
$routes->match(['get', 'post'], '/recovery', 'Auth::recovery_view', ['filter' => 'noauth']);
$routes->get('settings', 'Settings::index', ['filter' => 'auth']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
//$routes->get('profile/cities', 'Profile::cities', ['filter' => 'auth']);




// Users
$routes->get('users', 'Users::index', ['filter' => 'auth']);
$routes->get('users/(:any)', 'Users::item_view/$1', ['filter' => 'auth']);
$routes->get('users/(:any)/(:any)', 'Users::item_view/$1/$2', ['filter' => 'auth']);


// Users
$routes->get('companies', 'Companies::index', ['filter' => 'auth']);
$routes->get('companies/(:any)', 'Companies::item_view/$1', ['filter' => 'auth']);
$routes->get('companies/(:any)/(:any)', 'Companies::item_view/$1/$2', ['filter' => 'auth']);

// Receptions
$routes->get('receptions', 'Receptions::index', ['filter' => 'auth']);
$routes->get('receptions/(:any)', 'Receptions::item_view/$1', ['filter' => 'auth']);
$routes->get('receptions/(:any)/(:any)', 'Receptions::item_view/$1/$2', ['filter' => 'auth']);


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
