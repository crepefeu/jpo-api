<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fix autoload path
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Database {
    private $host;
    private $database_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        try {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();

            $this->host = $_ENV['DB_HOST'];
            $this->database_name = $_ENV['DB_NAME'];
            $this->username = $_ENV['DB_USER'];
            $this->password = $_ENV['DB_PASS'];
        } catch(Exception $e) {
            echo "Error loading environment: " . $e->getMessage();
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erreur de connexion à la base de données: " . $exception->getMessage();
        }

        return $this->conn;
    }
}