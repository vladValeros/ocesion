<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'ocesion';
    private $user = 'root';
    private $pass = '';
    private $pdo;
    
    // Constructor to initialize the database connection
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Method to get the PDO instance
    public function getConnection()
    {
        return $this->pdo;
    }

    
}
?>
