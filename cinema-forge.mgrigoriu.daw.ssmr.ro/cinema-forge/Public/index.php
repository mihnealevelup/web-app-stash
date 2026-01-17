<?php
// Prevent direct access to sensitive files
if (isset($_GET['url']) && strpos($_GET['url'], '..') !== false) {
    http_response_code(400);
    die('Invalid request');
}

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Production: log, not display
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../storage/logs/error.log');

// define project root
define('PROJECT_ROOT', dirname(__DIR__));
define('APP_PATH', PROJECT_ROOT . '/app');
define('PUBLIC_PATH', PROJECT_ROOT . '/Public');

// Include configuration
require PROJECT_ROOT . '/Config/config.php';

// auto-load classes
spl_autoload_register(function ($class) {
    $file = APP_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// start session
session_start();

// initialize router of the MVC framework
use Core\Router;

$router = new Router();

// define routes
$router->get('/catalog', 'Frontend/CatalogController@index');
$router->get('/film/:id', 'Frontend/ShowcaseController@show');
$router->get('/news', 'Frontend/NewsController@index');
$router->post('/contact', 'Frontend/ContactController@submit');

$router->post('/login', 'Admin/AuthController@login');
$router->get('/admin', 'Admin/DashboardController@index');
$router->get('/admin/films', 'Admin/FilmManagerController@index');
$router->post('/admin/films', 'Admin/FilmManagerController@store');
// ... more admin routes

// Dispatch
$router->dispatch($_GET['url'] ?? '/');
?>