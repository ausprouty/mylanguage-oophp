<?php



class BiblePassage
{
    private $dbConnection;
    public   $bpid;
    private  $referenceLocal;
    public   $text;
    public   $passageUrl;
    private  $dateLastUsed;
    private  $dateChecked;
    private  $timesUsed;


   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        $this->bpid = '';
        $this->referenceLocal= '';
        $this->text = '';
        $this->passageUrl='';
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed= 0;
            }
    public static function createBiblePassageId(string $bid, BibleReferenceInfo $passage){
        // 1026-Luke-10-1-42
        $bpid=$bid .'-' .
            $passage->bookID . '-' .
            $passage->chapterStart . '-'.
            $passage->verseStart . '-' .
            $passage->verseEnd;
        return $bpid;

    }
    public function findStoredById($bpid){
        $query = "SELECT * FROM bible_passages WHERE bpid = :bpid LIMIT 1";
        $params = array('bpid'=>$bpid);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_OBJ);
            if ($data){
                $this->bpid= $data->bpid;
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
        $query = "UPDATE bible_passages
            SET dateLastUsed = :dateLastUsed, timesUsed = :timesUsed
            WHERE bpid = :bpid LIMIT 1";
        $params = array(
            ':dateLastUsed' =>$this->dateLastUsed,
            ':timesUsed' =>  $this->timesUsed,
            'bpid'=>$this->bpid);
        $this->dbConnection->executeQuery($query, $params);
    }
    protected function insertPassageRecord ($bpid, $referenceLocal,  $text, $passageUrl){
        if ($text){
            $dateLastUsed = date("Y-m-d");
            $query = "INSERT INTO bible_passages (bpid, reference_local,  text, passage_url, dateLastUsed, dateChecked, timesUsed)
            VALUES (:bpid,:reference, :textValue, :passageUrl, :dateLastUsed, :dateChecked, :timesUsed)";
            $params = array(
                ':bpid' => $bpid,
                'reference'=> $referenceLocal,
                ':textValue' => $text,
                ':passageUrl'=> $passageUrl,
                ':dateLastUsed' => $dateLastUsed,
                ':dateChecked' => null,
                ':timesUsed' => 1
            );
            $this->dbConnection = new DatabaseConnection();
            $this->dbConnection->executeQuery($query, $params);
            }


        }

}