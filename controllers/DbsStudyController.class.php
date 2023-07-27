<?php
class DbsStudyController{
    private $data;

    public function __construct(){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT * FROM dbs_references
        ORDER BY lesson";
        try {
            $statement = $dbConnection->executeQuery($query);
            $this->data = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function formatWithEnglishTitle(){
        $formated = [];
        foreach ($this->data as $lesson){
            writeLogAppend('thisData', $lesson);
            $title = $lesson ['lesson'] . '. ' . $lesson['description']  . ' (' . $lesson['reference'] . ')';
            $obj =  new stdClass();
            $obj->title = $title;
            $obj->lesson = $lesson['lesson'];
            $formatted[] = $obj;
        }
        return $formatted;
    }
}