<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace( "App\Controllers" );
$routes->setDefaultController( "Main" );
$routes->setDefaultMethod( "main" );
$routes->setTranslateURIDashes( False );
$routes->set404Override();

/*
 * The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
 * where controller filters or CSRF protection are bypassed.
 * If you don't want to define all routes, please use the Auto Routing (Improved).
 * Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
 *
 */
//$routes->setAutoRoute(false);

helper( "cookie" );

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 *
 * We get a performance increase by specifying the default
 * route since we don't have to scan directories.
 */
$routes->get( "/", "Main::main" );
$routes->get( "/logout", "Main::logout" );
$routes->get( "/([^\n]*)", "Main::main" );

$routes->post( "/delete/account", "Action::deleteAccount" );
$routes->post( "/delete/officer", "Action::deleteOfficer" );
$routes->post( "/delete/publics", "Action::deletePublics" );
$routes->post( "/insert/complaint", "Action::insertComplaint" );
$routes->post( "/insert/officer", "Action::insertOfficer" );
$routes->post( "/insert/response", "Action::insertResponse" );
$routes->post( "/signin", "Action::signin" );
$routes->post( "/signin/officer", "Action::signin" );
$routes->post( "/signup", "Action::signup" );
$routes->post( "/update/password", "Action::updatePassword" );
$routes->post( "/update/profile", "Action::updateProfile" );
$routes->post( "/update/verify/report", "Action::updateVerifyReport" );
//$routes->post( "/([^\n]*)", "Main::main" );

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
if (is_file(APPPATH . "Config/" . ENVIRONMENT . "/Routes.php")) {
    require APPPATH . "Config/" . ENVIRONMENT . "/Routes.php";
}