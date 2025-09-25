<?php
session_start();
class Database
{
    private $dsn = "mysql:host=localhost;dbname=ticketsystem";
    private $dbUser = "root";
    private $dbPassword = "";

    public $conn;
    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->dbUser, $this->dbPassword);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->conn;
    }

    // Check Input
    public function testInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data; 
    }
    
    // Validate Name
    public function validateName($name)
    {
        if (!empty($name) && preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
            return $name;
        } else {
            return false;
        }
    }
    
}
