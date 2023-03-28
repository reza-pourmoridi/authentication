<?php
include 'config.php';

class DB {
    private $conn;
    private $host;
    private $db;
    private $user;
    private $pass;

    function __construct($host, $db, $user, $pass) {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pass = $pass;

        $this->connect();
    }

    function __destruct() {
        $this->conn = null;
    }

    private function connect() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db";
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insert($table, $data) {
        try {
            $keys = array_keys($data);
            $values = array_values($data);
            $fieldList = implode(",", $keys);
            $placeholderList = rtrim(str_repeat('?,', count($values)), ',');
            $sql = "INSERT INTO $table ($fieldList) VALUES ($placeholderList)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return $this->conn->lastInsertId();
        } catch(PDOException $e) {
            echo "Insert failed: " . $e->getMessage();
        }
    }

    public function update($table, $data, $condition) {
        try {
            $keys = array_keys($data);
            $values = array_values($data);
            $fieldList = '';
            for ($i=0; $i<count($keys); $i++) {
                $fieldList .= $keys[$i] . '=?,';
            }
            $fieldList = rtrim($fieldList, ',');
            $sql = "UPDATE $table SET $fieldList WHERE $condition";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return $stmt->rowCount();
        } catch(PDOException $e) {
            echo "Update failed: " . $e->getMessage();
        }
    }

    public function delete($table, $condition) {
        try {
            $sql = "DELETE FROM $table WHERE $condition";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        } catch(PDOException $e) {
            echo "Delete failed: " . $e->getMessage();
        }
    }

    public function select($table, $condition='', $order='', $start='', $limit='') {
        try {
            $sql = "SELECT * FROM $table";
            if (!empty($condition)) {
                $sql .= " WHERE $condition";
            }
            if (!empty($order)) {
                $sql .= " ORDER BY $order";
            }
            if (!empty($start) || !empty($limit)) {
                $sql .= " LIMIT $start, $limit";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Select failed: " . $e->getMessage();
        }
    }
}

