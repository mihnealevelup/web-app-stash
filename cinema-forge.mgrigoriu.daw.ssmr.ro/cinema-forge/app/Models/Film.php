<?php
namespace Models;

use Core\Model;
use PDO;
use PDOException;

class Film extends Model {
    protected $table = 'films';
    protected $fillable = ['title', 'slug', 'synopsis', 'release_year', 'genre', 'poster', 'trailer_url', 'status'];

    // valori distincte pentru genurile din filtrele dropdown
    public function getDistinctGenres() {
        try {
            $sql = "SELECT DISTINCT genre FROM {$this->table} WHERE genre IS NOT NULL ORDER BY genre ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("getDistinctGenres error: " . $e->getMessage());
            return [];
        }
    }

    // ani de lansare distincti pentru filtrele dropdown
    public function getDistinctYears() {
        try {
            $sql = "SELECT DISTINCT release_year FROM {$this->table} WHERE release_year IS NOT NULL ORDER BY release_year DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("getDistinctYears error: " . $e->getMessage());
            return [];
        }
    }

    // Gasim film dupa slug (pentru URL-uri SEO-friendly)
    public function findBySlug($slug) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':slug', $slug);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("findBySlug error: " . $e->getMessage());
            return false;
        }
    }

    // obtinem talentele asociate unui film
    public function getTalents($filmId) {
        try {
            $sql = "SELECT t.*, ft.character_name 
                    FROM talents t 
                    INNER JOIN film_talent ft ON t.id = ft.talent_id 
                    WHERE ft.film_id = :film_id 
                    ORDER BY t.role_type, t.name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':film_id', $filmId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getTalents error: " . $e->getMessage());
            return [];
        }
    }

    // doar filme lansate pentru catalogul public
    public function getPublicFilms($conditions = []) {
        $conditions['status'] = 'released';
        return $this->findAll($conditions, 'release_year DESC, title ASC');
    }
}