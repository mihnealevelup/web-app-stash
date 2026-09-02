<?php
namespace Core;
// Clasa abstractă Model (CRUD generic)

use PDO;
use PDOException;

abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = []; // fields allowed for mass assignment

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // CREATE
    public function create(array $data) {
        try {
            $data = $this->filterFillable($data);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create error: " . $e->getMessage());
            return false;
        }
    }

    // READ - Find by ID
    public function find($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Find error: " . $e->getMessage());
            return false;
        }
    }

    // READ - Find all with optional conditions
    public function findAll($conditions = [], $orderBy = null, $limit = null) {
        try {
            $sql = "SELECT * FROM {$this->table}";

            if (!empty($conditions)) {
                $where = [];
                foreach ($conditions as $key => $value) {
                    $where[] = "$key = :$key";
                }
                $sql .= " WHERE " . implode(' AND ', $where);
            }

            if ($orderBy) {
                $sql .= " ORDER BY $orderBy";
            }

            if ($limit) {
                $sql .= " LIMIT $limit";
            }

            $stmt = $this->db->prepare($sql);

            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("FindAll error: " . $e->getMessage());
            return [];
        }
    }

    // UPDATE
    public function update($id, array $data) {
        try {
            $data = $this->filterFillable($data);
            $data['updated_at'] = date('Y-m-d H:i:s');

            $setClause = [];
            foreach ($data as $key => $value) {
                $setClause[] = "$key = :$key";
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $setClause)
                . " WHERE {$this->primaryKey} = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update error: " . $e->getMessage());
            return false;
        }
    }

    // DELETE
    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }

    // filter allowed fields (mass assignment protection)
    protected function filterFillable(array $data) {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }

    // count records
    public function count($conditions = []) {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table}";

            if (!empty($conditions)) {
                $where = [];
                foreach ($conditions as $key => $value) {
                    $where[] = "$key = :$key";
                }
                $sql .= " WHERE " . implode(' AND ', $where);
            }

            $stmt = $this->db->prepare($sql);

            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Count error: " . $e->getMessage());
            return 0;
        }
    }
}
