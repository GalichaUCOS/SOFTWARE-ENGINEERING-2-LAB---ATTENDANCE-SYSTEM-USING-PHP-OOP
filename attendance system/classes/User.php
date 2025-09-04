<?php
require_once __DIR__ . "/../db.php";

class User {
    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // Reusable guards
    public static function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
            exit;
        }
    }

    public static function requireRole($role) {
        self::requireLogin();
        if ($_SESSION['user']['role'] !== $role) {
            http_response_code(403);
            die("Access denied");
        }
    }

    // Auth
    public function register($name, $email, $password, $role, $course_id = null, $year_level = null) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("
            INSERT INTO users (name, email, password, role, course_id, year_level)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssssii", $name, $email, $hashed, $role, $course_id, $year_level);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    // Utility
    public function getAllCourses() {
        $res = $this->conn->query("SELECT id, course_name FROM courses ORDER BY course_name ASC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}
