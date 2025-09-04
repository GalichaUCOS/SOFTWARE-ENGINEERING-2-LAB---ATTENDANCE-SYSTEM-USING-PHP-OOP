<?php
class Database {
    private $host = "localhost";
    private $db = "attendance_db";
    private $user = "root";
    private $pass = "";
    protected $conn;

    public function __construct() {}

    public function connect() {
        if ($this->conn) return $this->conn;
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die("DB Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
        return $this->conn;
    }
}
