<?php
// creates and manages PDO connections
namespace Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    // private constructor - prevents external instantiations
    private function __construct() {
        try {
            // uses the constants from config.php
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

            $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false, // Protecție SQL Injection
            ]);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());

            if (APP_DEBUG) {
                die("Database connection failed: " . $e->getMessage());
            } else {
                die("Database connection failed. Please contact administrator.");
            }
        }
    }

    // returns the only instance (Singleton pattern)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // returns PDO connexion
    public function getConnection() {
        return $this->connection;
    }

    // prevents instance cloning
    private function __clone() {}

    // prevents deserialization of the instance
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}
