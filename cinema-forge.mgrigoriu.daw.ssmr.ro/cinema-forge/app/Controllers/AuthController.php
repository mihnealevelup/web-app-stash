<?php
namespace Controllers;

use Services\AuthService;
use Helpers\CSRF;

class AuthController extends BaseController {

    public function showLogin() {
        // Deja logged in? Redirect catre admin
        if (AuthService::isLoggedIn()) {
            $this->redirect('/admin');
        }

        $this->render('auth/login', [
            'csrf_token' => CSRF::generateCSRFToken()
        ]);
    }

    public function login() {
        // Validam token CSRF
        if (!CSRF::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Invalid CSRF token');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->render('auth/login', [
                'error' => 'Username and password are required.',
                'csrf_token' => CSRF::generateCSRFToken()
            ]);
            return;
        }

        if (AuthService::login($username, $password)) {
            $this->redirect('/admin');
        } else {
            $this->render('auth/login', [
                'error' => 'Invalid credentials.',
                'csrf_token' => CSRF::generateCSRFToken()
            ]);
        }
    }

    public function logout() {
        AuthService::logout();
        $this->redirect('/');
    }
}