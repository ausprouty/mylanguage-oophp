<?php

//todo  I think this needs a rewrite
class DbsReference {
    private $dbConnection;
    private $lesson;
    public $bibleReferenceInfo;
    public $reference;
    public $description;

    public function __construct($lesson = null, BibleReferenceInfo $bibleReferenceInfo = null, $reference= null, $description= null) {
        $this->dbConnection = new DatabaseConnection();
        $this->lesson = $lesson;
        $this->bibleReferenceInfo = $bibleReferenceInfo;
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
                $this->bibleReferenceInfo = json_decode($data->bible_reference_info);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }



}
?>
