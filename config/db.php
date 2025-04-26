<?php

class Database {
    private $host = 'localhost';
    private $dbName = 'payroll_timesheet';
    private $username = 'root'; // Update with your DB username
    private $password = ''; // Update with your DB password
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}
?>
