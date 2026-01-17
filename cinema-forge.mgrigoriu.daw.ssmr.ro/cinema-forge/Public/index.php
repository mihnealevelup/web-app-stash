
<?php
// Define project root paths
define('PROJECT_ROOT', dirname(__DIR__));
define('APP_PATH', PROJECT_ROOT . '/app');
define('PUBLIC_PATH', __DIR__);

// Include configuration
require APP_PATH . '/Config/config.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/app/storage/logs/error.log');

// Autoload classes
spl_autoload_register(function ($class) {
    $file = APP_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Start session
session_start();

// Validate URL input (use Security class)
$url = $_GET['url'] ?? '/';
if (!Helpers\Security::validateUrl($url)) {
    http_response_code(400);
    die('Invalid request');
}

// Initialize router
use Core\Router;

$router = new Router();

// Define routes
$router->get('/catalog', 'Frontend/CatalogController@index');
$router->get('/film/:id', 'Frontend/ShowcaseController@show');
// ... rest of routes

// Dispatch
$router->dispatch($url);