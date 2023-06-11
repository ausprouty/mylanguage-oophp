<?php


class DatabaseConnection{
    private $dbConnection;
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct(){
      $this->host = DBHOST;
      $this->username = USERNAME;
      $this->password = PASSWORD;
      $this->database = DATABASE;
      $this->connect();

    }
    private function connect() {
      try {
          $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
          $this->connection = new PDO($dsn, $this->username, $this->password);
          // Set PDO error mode to exception
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          throw new Exception("Failed to connect to the database: " . $e->getMessage());
      }
    }

    public function executeQuery($query, $params = []) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            throw new Exception("Error executing the query: " . $e->getMessage());
        }
    }

    public function closeConnection() {
        $this->connection = null;
    }
}
