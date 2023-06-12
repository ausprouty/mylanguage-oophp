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
                $this->updateUse();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    private function setBiblePassageValues($data){

    }
    private function updateUse(){

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
                $this->updateUse();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }


    }
    private function updateDatabase(){



    }


}