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
          $this->dbConnection = new PDO($dsn, $this->username, $this->password);
          // Set PDO error mode to exception
          $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          throw new Exception("Failed to connect to the database: " . $e->getMessage());
      }
    }

    public function executeQuery(string $query, array $params = []) {
        try {
            $statement = $this->dbConnection->prepare($query);
            if (empty($params)) {
                $statement->execute();
            } else {
                $statement->execute($params);
            }
            return $statement;
        } catch (PDOException $e) {
            throw new Exception("Error executing the query: " . $e->getMessage());
        }
    }

    public function closeConnection() {
        $this->dbConnection = null;
    }
}
