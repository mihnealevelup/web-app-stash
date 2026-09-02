<?php

namespace Helpers;

class CSRF
{

    // protection against CSRF
    public static function generateCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken($token)
    {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    public static function sanitize($input)
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public static function escape($string)
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

    public static function validateUrl($url)
    {
        // Block path traversal attempts (including URL-encoded variants)
        $decoded = urldecode($url);
        if (strpos($decoded, '..') !== false || strpos($decoded, "\0") !== false) {
            return false;
        }
        return true;
    }
}