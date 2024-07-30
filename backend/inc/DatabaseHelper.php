<?php

class DatabaseHelper {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    // Select all records from a table
    public function selectAll($tableName) {
        $query = "SELECT * FROM $tableName";
        return $this->db->fetchData($query);
    }

    // Select records with a WHERE clause
    public function selectWhere($tableName, $whereClause, $params = []) {
        $query = "SELECT * FROM $tableName WHERE $whereClause";
        return $this->db->fetchData($query, $params);
    }

    // Select specific columns from a table
    public function selectColumns($tableName, $columns = []) {
        $columnsString = implode(', ', $columns);
        $query = "SELECT $columnsString FROM $tableName";
        return $this->db->fetchData($query);
    }

    // Select specific columns with a WHERE clause
    public function selectColumnsWhere($tableName, $columns = [], $whereClause, $params = []) {
        $columnsString = implode(', ', $columns);
        $query = "SELECT $columnsString FROM $tableName WHERE $whereClause";
        return $this->db->fetchData($query, $params);
    }

    // Insert a new record into a table
    public function insert($tableName, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        return $this->db->executeQuery($query, array_values($data));
    }

    // Update records in a table with a WHERE clause
    public function update($tableName, $data, $whereClause, $params = []) {
        $setClause = implode(', ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($data)));

        $query = "UPDATE $tableName SET $setClause WHERE $whereClause";
        return $this->db->executeQuery($query, array_merge(array_values($data), $params));
    }

    // Delete records from a table with a WHERE clause
    public function delete($tableName, $whereClause, $params = []) {
        $query = "DELETE FROM $tableName WHERE $whereClause";
        return $this->db->executeQuery($query, $params);
    }
}
?>
