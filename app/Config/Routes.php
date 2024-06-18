<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/history', 'Home::history');
$routes->get('/report', 'Home::report');
$routes->get('/order', 'Home::order');
$routes->get('/fluctuation', 'Home::fluctuation');
$routes->get('/change', 'Home::change');

//api request
$routes->get('/api/stockdatas', 'Api\ApiStockData::index');
$routes->get('/api/stockdatas/sell', 'Api\ApiStockData::sell');
$routes->get('/api/stockdatas/history', 'Api\ApiStockData::history');
$routes->get('/api/stockdatas/datesAndTimesSelect', 'Api\ApiStockData::datesAndTimesSelect');
$routes->get('/api/group/list', 'Api\ApiGroup::groupActivedList');
$routes->get('/api/orders', 'Api\ApiOrderController::index');
$routes->get('/api/filter/3up2down', 'Api\ApiFilterData::filter3up2down');
$routes->get('/api/filter/3up1down', 'Api\ApiFilterData::filter3up1down');
$routes->get('/api/filter/3up', 'Api\ApiFilterData::filter3up');
$routes->get('/api/fluctuation', 'Api\ApiFluctuation::index');

//admin panel
$routes->get('/admin/group', 'Admin\GroupController::index');
$routes->post('/admin/group/save/(:num)', 'Admin\GroupController::save/$1');

$routes->get('/admin/code', 'Admin\CodeController::index');
$routes->post('/admin/code/save/(:num)', 'Admin\CodeController::save/$1');
$routes->get('/admin/code/delete/(:num)', 'Admin\CodeController::delete/$1');

/*
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
