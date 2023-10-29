<?php 
class QueryModel {
    private $db;
    private $data;
    public function __construct(){
        $this->data = array();
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $this->db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function executeQuery($query, $params) {
        $stmt = $this->db->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt;
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
        
    public function insert($table, $data) {
        $sanitizedData = $this->sanitizeData($data);

        $columns = implode(", ", array_keys($sanitizedData));
        $placeholders = ":" . implode(", :", array_keys($sanitizedData));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($sanitizedData);
            return 1;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function select($table, $condition, $columns = null) {
        if($columns){
            $query = "SELECT $columns FROM $table WHERE $condition";    
        }else{
            $query = "SELECT * FROM $table WHERE $condition";    
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->data = array();
        }
        
        return $this->data;
    }

    public function selectUnique($table, $condition, $columns = null) {
        if($columns){
            $query = "SELECT $columns FROM $table WHERE $condition";    
        }else{
            $query = "SELECT * FROM $table WHERE $condition";    
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->data = array();
        }
        if(isset($this->data[0])){
            return $this->data[0];
        }else{
            return 0;
        }
    }

    public function update($table, $data, $condition) {
        $sanitizedData = $this->sanitizeData($data);

        $setValues = [];
        foreach ($sanitizedData as $key => $value) {
            $setValues[] = $key . " = :" . $key;
        }
        $setClause = implode(", ", $setValues);

        $query = "UPDATE $table SET $setClause WHERE $condition";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($sanitizedData);
            return 1;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function delete($table, $condition) {
        $query = "DELETE FROM $table WHERE $condition";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function lastid($table){
        $query = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->data = array();
        }
        
        return $this->data[0]['id'];
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