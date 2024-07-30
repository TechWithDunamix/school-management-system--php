<?php
require_once 'config.php';

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    public $connection; // Changed to public for access

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function disconnect() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function executeQuery($query, $params = []) {
        $stmt = $this->connection->prepare($query);

        if ($params) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            return $stmt->get_result();
        } else {
            return false;
        }
    }

    public function fetchData($query, $params = []) {
        $result = $this->executeQuery($query, $params);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }
}
?>
