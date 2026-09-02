<?php
namespace Models;

// Doar pentru admin auth

use Core\Model;
use PDO;
use PDOException;

class User extends Model {
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'role'];

    // gasim membru member dupa username
    public function findByUsername($username) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("FindByUsername error: " . $e->getMessage());
            return false;
        }
    }

    // gasim membru member dupa email
    public function findByEmail($email) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("FindByEmail error: " . $e->getMessage());
            return false;
        }
    }

    // obtinem tot stafful grupat dupa rol
    public function getByRole($role) {
        return $this->findAll(['role' => $role], 'username ASC');
    }
}