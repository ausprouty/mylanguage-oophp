<?php



class BiblePassage
{
    private $dbConnection;
    public   $id;
    private  $text;
    private  $dateLastUsed;
    private  $dateChecked;
    private  $timesUsed;


   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
    }
    public static function createBiblePassageId(string $bid, BibleReferenceInfo $passage){
        // 1026-Luke-10-1-42
        $id=$bid .'-' .
            $passage->bookID . '-' .
            $passage->chapterStart . '-'.
            $passage->verseStart . '-' .
            $passage->verseEnd;
        return $id;

    }
    public function findStoredById($id){
        $query = "SELECT * FROM bible_passages WHERE id = :id LIMIT 1";
        $params = array('id'=>$id);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetchAll(PDO::FETCH_OBJ);
            if ($data){
                $this->id= $data->id;
                $this->text = $data->text;
                $this->dateLastUsed = $data->dateLastUsed;
                $this->dateChecked = $data->dateChecked;
                $this->timesUsed = $data->timesUsed;
                $this->updatePassageUse();
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    private function setBiblePassageValues($data){

    }
    private function updatePassageUse(){
        $this->dateLastUsed = date("Y-m-d");
        $this->timesUsed=$this->timesUsed + 1;
        $query = "UPDATE bible_passages SET WHERE id = :id LIMIT 1";
        $params = array('id'=>$id);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetchAll(PDO::FETCH_OBJ);
            if ($data){
                $this->id= $data->id;
                $this->text = $data->text;
                $this->dateLastUsed = $data->dateLastUsed;
                $this->dateChecked = $data->dateChecked;
                $this->timesUsed = $data->timesUsed;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    protected function insertRecord($id, $text){
        $dateLastUsed = date("Y-m-d");
        $query = "INSERT INTO bible_passages (id, text, dateLastUsed, dateChecked, timesUsed)
           VALUES (:id, :text, :dateLastUsed, :dateChecked, :timesUsed);
        $params = array(
            ':id' => $id ,
            ':text' => $text,
            ':dateLastUsed' => $dateLastUsed,
            ':dateChecked' => null,
            ':timesUsed' => 1
        );
        $statement = $this->dbConnection->executeQuery($query, $params);
    }
}