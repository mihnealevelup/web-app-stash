<?php
namespace Services;

use Models\User;

class AuthService {

    // ierarhie: admin > manager > crew
    private static $roleHierarchy = [
        'admin' => 3,
        'manager' => 2,
        'crew' => 1
    ];

    //incercare log in drept staff
    public static function login($username, $password) {
        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Permitem doar roluri de staff
        if (!in_array($user['role'], ['admin', 'manager', 'crew'])) {
            return false;
        }

        // setam sesiunea superglobala
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Prevent session fixation
        session_regenerate_id(true);

        return true;
    }

    // log out membru staff curent
    public static function logout() {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    // verificam daca vreun membru staff este logat
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // obtinem rolul curent
    public static function getRole() {
        return $_SESSION['role'] ?? null;
    }

    // obtinem user ID curent
    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    // obtinem username curent
    public static function getUsername() {
        return $_SESSION['username'] ?? null;
    }

    // Verificam daca userul are vreun rol
    public static function hasRole($role) {
        return self::isLoggedIn() && self::getRole() === $role;
    }

    /** verificam daca userul curent are minim nivelul unui rol
     ex: hasMinRole('manager') intoarce true pentru admin si manager */
    public static function hasMinRole($minRole) {
        if (!self::isLoggedIn()) {
            return false;
        }

        $currentLevel = self::$roleHierarchy[self::getRole()] ?? 0;
        $requiredLevel = self::$roleHierarchy[$minRole] ?? 0;

        return $currentLevel >= $requiredLevel;
    }

     // cerem login — redirect catre /login daca nu e autentificat
    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            header("Location: /login");
            exit;
        }
    }

    // Dam eroare daca nu are rolul minim alocat — 403
    public static function requireRole($crew) {
        self::requireAuth();

        if (!self::hasMinRole($crew)) {
            http_response_code(403);
            die('Forbidden — insufficient permissions');
        }
    }

    // hash-uim parola (pentru seeding/creare conturi de staff)
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}