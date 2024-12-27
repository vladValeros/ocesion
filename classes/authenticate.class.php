<?php
session_start();
require_once 'database.class.php'; // Include the Database class

class Authenticator {
    private $pdo;

    // Constructor now uses Database class to obtain PDO connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Login method to authenticate users
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return true;
        }
        return false;
    }

    // Check if a user is logged in
    public function is_logged_in() {
        return isset($_SESSION['user']);
    }

    // Get the role of a user
    public function getUserRole($username) {
        $stmt = $this->pdo->prepare("SELECT role FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['role'] : null;
    }
}

// Instantiate Database and get the PDO connection
$database = new Database();
$pdo = $database->getConnection();

// Instantiate the Authenticator class with the PDO connection
$auth = new Authenticator($pdo);
?>
