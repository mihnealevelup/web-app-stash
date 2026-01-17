<?php
namespace Controllers;

abstract class BaseController {
    protected $view;

    public function __construct() {
        $this->view = new \stdClass();
    }

    protected function render($view, $data = []) {
        extract($data);
        require APP_PATH . "/Views/$view.php";
    }

    protected function redirect($path) {
        header("Location: " . APP_URL . "/$path");
        exit;
    }

    protected function isAdmin() {
        return isset($_SESSION['admin_id']);
    }

    protected function requireAdmin() {
        if (!$this->isAdmin()) {
            http_response_code(403);
            die('Unauthorized');
        }
    }
};
?>.