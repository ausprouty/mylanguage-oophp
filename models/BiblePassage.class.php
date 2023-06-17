<?php



class BiblePassage
{
    private    $dbConnection;
    public     $bpid;
    protected  $referenceLocal;
    protected  $passageText;
    protected  $passageUrl;
    protected  $dateLastUsed;
    protected  $dateChecked;
    protected  $timesUsed;

   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        $this->bpid = '';
        $this->referenceLocal= '';
        $this->passageText = '';
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
                $this->referenceLocal = $data->referenceLocal;
                $this->passageText = $data->passageText;
                $this->passageUrl = $data->passageUrl;
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
    protected function insertPassageRecord($bpid, $referenceLocal,  $passageText, $passageUrl)
    {
        if ($passageText) {
            $dateLastUsed = date("Y-m-d");
            $query = "INSERT INTO bible_passages (bpid, referenceLocal,  passageText, passageUrl, dateLastUsed, dateChecked, timesUsed)
            VALUES (:bpid,:referenceLocal, :passageText, :passageUrl, :dateLastUsed, :dateChecked, :timesUsed)";
            $params = array(
                ':bpid' => $bpid,
                'referenceLocal' => $referenceLocal,
                ':passageText' => $passageText,
                ':passageUrl' => $passageUrl,
                ':dateLastUsed' => $dateLastUsed,
                ':dateChecked' => null,
                ':timesUsed' => 1
            );
            $this->dbConnection = new DatabaseConnection();
            $this->dbConnection->executeQuery($query, $params);
        }
    }
    protected function savePassageRecord($bpid, $referenceLocal,  $passageText, $passageUrl){
        $this->dbConnection = new DatabaseConnection();
        $query = 'SELECT bpid FROM bible_passages WHERE bpid = :bpid LIMIT 1';
        $params = array(':bpid'=> $bpid);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
        if ($data->bpid){
            $query = "UPDATE bible_passages
            SET  referenceLocal = :referenceLocal,
            passageText = :passageText,
            passageUrl = :passageUrl
            WHERE bpid = :bpid LIMIT 1";
            $params = array(
                ':referenceLocal' => $referenceLocal,
                ':passageText'=> $passageText,
                ':passageUrl'=> $passageUrl,
                ':bpid' => $this->bpid
            );
            $this->dbConnection->executeQuery($query, $params);
        }
        else{
           $this->insertPassageRecord($bpid, $referenceLocal,  $passageText, $passageUrl);
        }

    }


    protected function updateDateChecked(){

        $query = "UPDATE bible_passages
            SET  dateChecked = :today
            WHERE bpid = :bpid LIMIT 1";
        $params = array(
            ':today' => date("Y-m-d"),
            ':bpid' => $this->bpid
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }
    protected function updatePassageUrl()
    {
        $query = "UPDATE bible_passages
            SET  passageUrl = :passageUrl
            WHERE bpid = :bpid LIMIT 1";
        $params = array(
            ':passageUrl' => $this->passageUrl,
            ':bpid' => $this->bpid
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }

    private function updatePassageUse()
    {
        $this->dateLastUsed = date("Y-m-d");
        $this->timesUsed = $this->timesUsed + 1;
        $query = "UPDATE bible_passages
            SET dateLastUsed = :dateLastUsed, timesUsed = :timesUsed
            WHERE bpid = :bpid LIMIT 1";
        $params = array(
            ':dateLastUsed' => $this->dateLastUsed,
            ':timesUsed' =>  $this->timesUsed,
            ':bpid' => $this->bpid
        );
        $this->dbConnection->executeQuery($query, $params);
    }
    protected function updateReferenceLocal()
    {   echo ("In updateReferenceLocal with value of $this->referenceLocal and bpid of $this->bpid");
        $query = "UPDATE bible_passages
            SET referenceLocal = :referenceLocal
            WHERE bpid = :bpid LIMIT 1";
        $params = array(
            ':referenceLocal' => $this->referenceLocal,
            ':bpid' => $this->bpid
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }
    protected function updatepassageText()
    {
        $query = "UPDATE bible_passages
            SET  text = :text
            WHERE bpid = :bpid LIMIT 1";
        $params = array(
            ':text' => $this->passageText,
            ':bpid' => $this->bpid
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }


}