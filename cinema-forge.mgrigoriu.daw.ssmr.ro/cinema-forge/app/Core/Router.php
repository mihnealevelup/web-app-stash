<?php
namespace Core;

class Router {
    private $routes = [];

    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch($url) {
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Incercam sa potrivim route-ul
        foreach ($this->routes[$method] ?? [] as $path => $handler) {
            if ($this->matchRoute($path, $url)) {
                return $this->executeHandler($handler);
            }
        }

        // Default: 404 - lolosim erorile deja existente din folderul Public
        http_response_code(404);
        $publicErrorFile = PUBLIC_PATH . '/404.shtml';

        if (file_exists($publicErrorFile)) {
            require $publicErrorFile;
        } else {
            echo "<h1>404 - Page Not Found</h1>";
        }
    }

    private function matchRoute($pattern, $url) {
        // Handle homepage
        if ($pattern === '/' && $url === '') {
            return true;
        }

        $pattern = trim($pattern, '/');
        $pattern = preg_replace('/:[a-z_]+/', '([a-z0-9-]+)', $pattern);
        $pattern = '#^' . $pattern . '$#i';

        if (preg_match($pattern, $url, $matches)) {
            array_shift($matches);
            $this->params = $matches;
            return true;
        }
        return false;
    }

    private function executeHandler($handler) {
        list($controller, $action) = explode('@', $handler);
        $class = 'Controllers\\' . $controller;

        if (!class_exists($class)) {
            http_response_code(500);
            die("Controller not found: $class");
        }

        $instance = new $class();
        call_user_func_array([$instance, $action], $this->params ?? []);
    }
}