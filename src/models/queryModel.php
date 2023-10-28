<?php

class QueryModel {
    private $db;

    public function __construct() {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $this->db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($query, $params = array()) {
        try {
            $sanitizedParams = $this->sanitizeData($params);
            $stmt = $this->executeQuery($query, $sanitizedParams);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function select($table, $condition) {
        $query = "SELECT * FROM $table WHERE $condition";
        return $this->executeQuery($query);
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->executeQuery($query, $data);
    }

    public function update($table, $data, $condition) {
        $setValues = [];
        foreach ($data as $key => $value) {
            $setValues[] = "$key = :$key";
        }
        $setClause = implode(', ', $setValues);
        $query = "UPDATE $table SET $setClause WHERE $condition";
        return $this->executeQuery($query, $data);
    }

    public function delete($table, $condition) {
        $query = "DELETE FROM $table WHERE $condition";
        return $this->executeQuery($query);
    }

    public function lastId($table) {
        $query = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
        $result = $this->executeQuery($query);
        if ($result) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        }
        return null;
    }

    private function executeQuery($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    private function sanitizeData($data) {
        if (is_string($data)) {
            $sanitizedData = $this->db->quote($data);
        } elseif (is_int($data)) {
            $sanitizedData = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        } elseif (is_float($data)) {
            $sanitizedData = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            $sanitizedData = $data;
        }

        return $sanitizedData;
    }
}
