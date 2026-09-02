<?php
namespace Models;

use Core\Model;
use PDO;
use PDOException;

class Talent extends Model {
    protected $table = 'talents';
    protected $fillable = ['name', 'role_type', 'bio', 'photo'];

    // obtinerea talentelor dupa tipul rolului
    public function getByRoleType($roleType) {
        return $this->findAll(['role_type' => $roleType], 'name ASC');
    }

    // obtinem filmele asociate unui talent
    public function getFilms($talentId) {
        try {
            $sql = "SELECT f.*, ft.character_name 
                    FROM films f 
                    INNER JOIN film_talent ft ON f.id = ft.film_id 
                    WHERE ft.talent_id = :talent_id 
                    ORDER BY f.release_year DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':talent_id', $talentId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Talent getFilms error: " . $e->getMessage());
            return [];
        }
    }
}