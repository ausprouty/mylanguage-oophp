<?php
class DbsStudyController{

    public function getOptions(){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT * FROM dbs_references
        ORDER BY lesson";
        try {
            $statement = $dbConnection->executeQuery($query);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}