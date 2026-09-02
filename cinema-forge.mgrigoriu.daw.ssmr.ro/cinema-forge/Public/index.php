<?php
// definim calea root a proiectului
define('PROJECT_ROOT', dirname(__DIR__));
define('APP_PATH', PROJECT_ROOT . '/app');
define('PUBLIC_PATH', __DIR__);

// Include configuration
require APP_PATH . '/Config/config.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/app/storage/logs/error.log');

// Autoload classes
spl_autoload_register(function ($class) {
    $file = APP_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});     // acum Database.php poate folosi DB_HOST, DB_USER, etc.

// pornim sesiunea
session_start();

// initializare Router
use Core\Router;
$router = new Router();

// validare input URL (folosim clasa Security)
$url = $_GET['url'] ?? '/';
if (!Helpers\CSRF::validateUrl($url)) {
    http_response_code(400);
    die('Invalid request');
}

// Definim rutele
// =====================
// Frontend routes (public, no login)
// =====================
$router->get('/', 'CatalogController@index');
$router->get('/catalog', 'CatalogController@index');
$router->get('/film/:id', 'ShowcaseController@show');
$router->get('/news', 'NewsController@index');
$router->get('/contact', 'ContactController@show');
$router->post('/contact', 'ContactController@submit');


// =====================
// Auth routes (staff only: admin, manager, crew)
// =====================
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// =====================
// Admin routes (roluri-protejate in controllere)
// =====================
$router->get('/admin', 'DashboardController@index');

// Film management (admin + manager)
$router->get('/admin/films', 'FilmManagerController@index');
$router->get('/admin/films/create', 'FilmManagerController@create');
$router->post('/admin/films', 'FilmManagerController@store');
$router->get('/admin/films/edit/:id', 'FilmManagerController@edit');
$router->post('/admin/films/update/:id', 'FilmManagerController@update');
$router->post('/admin/films/delete/:id', 'FilmManagerController@delete');

// Talent management (admin + manager)
$router->get('/admin/talents', 'TalentManagerController@index');
$router->get('/admin/talents/create', 'TalentManagerController@create');
$router->post('/admin/talents', 'TalentManagerController@store');
$router->get('/admin/talents/edit/:id', 'TalentManagerController@edit');
$router->post('/admin/talents/update/:id', 'TalentManagerController@update');
$router->post('/admin/talents/delete/:id', 'TalentManagerController@delete');

// Dispatch
$router->dispatch($_GET['url'] ?? '/');