<?php

//todo  I think this needs a rewrite
class DbsReference {
    private $dbConnection;
    private $lesson;
    public $dbtArray;
    public $reference;
    public $description;

    public function __construct($lesson = null, $dbtArray= null, $reference= null, $description= null) {
        $this->dbConnection = new DatabaseConnection();
        $this->lesson = $lesson;
        $this->dbtArray = $dbtArray;
        $this->reference = $reference;
        $this->description = $description;
    }

    public function getLesson($lesson)
    {
        $query = "SELECT * FROM dbs_references WHERE lesson = :lesson";
        $params = array('lesson'=>$lesson);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_OBJ);
            if($data){

                $this->lesson =$data->lesson;
                $this->reference= $data->reference;
                $this->description =$data->description;
                $this->dbtArray = $this->checkDbtArray($data->dbt_array);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }


    // Getters and setters for each property

    public function setLesson($lesson) {
        $this->lesson = $lesson;
    }

    public function getDbtArray() {
        return $this->dbtArray;
    }

    public function setDbtArray($dbtArray) {
        $this->dbtArray = $dbtArray;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
?>
