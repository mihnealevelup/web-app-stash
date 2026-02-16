<?php
namespace Controllers;

use Services\AuthService;

abstract class BaseController {
    protected $view;
    protected $layout = 'main'; // layout default

    public function __construct() {
        $this->view = new \stdClass();
    }

    protected function render($view, $data = []) {
        extract($data);

        $viewPath = APP_PATH . '/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            die("View not found: {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $layoutPath = APP_PATH . '/layouts/' . $this->layout . '.php';

        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    protected function redirect($path) {
        $url = rtrim(APP_URL ?? '', '/') . '/' . ltrim($path, '/');
        header("Location: {$url}");
        exit;
    }

    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // necesita staff login (admin, manager, crew)
    protected function requireAuth() {
        AuthService::requireAuth();
    }

    //necesita nivel specific minim al rolulului
    // Exemplu: $this->requireRole('manager') allows admin + manager

    protected function requireRole($minRole) {
        AuthService::requireRole($minRole);
    }
}