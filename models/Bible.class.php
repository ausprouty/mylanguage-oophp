<?php


class Bible {
  private  $dbConnection;
  public $bid;
  public $source;
  public $externalId;
  public $abbreviation;
  public $volumeName;
  public $volumeNameAlt;
  public $languageCode;
  public $languageCodeHL;
  public $languageName;
  public $languageEnglish;
  public $languageCodeIso;
  public $languageCodeDrupal;
  public $idBibleGateway;
  public $collectionCode;
  public $rightToLeft;
  public $numerals;
  public $spacePdf;
  public $noBoldPdf;
  public $format;
  public $text;
  public $audio;
  public $video;

  public $weight;
  public $dateVerified;

   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        $this->bid = ' ';
        $this->source = ' ';
        $this->externalId = NULL;
        $this->volumeName = ' ';
        $this->volumeNameAlt = NULL;
        $this->languageCodeHL = ' ';
        $this->languageCodeIso = ' ';
        $this->languageName = ' ';
        $this->languageEnglish = ' ';
        $this->idBibleGateway = ' ';
        $this->collectionCode = ' ';
        $this->format = '';
        $this->audio = '';
        $this->text = '';
        $this->video = '';
        $this->numerals = ' ';
        $this->rightToLeft = ' ';
        $this->spacePdf = NULL;
        $this->noBoldPdf = ' ';
        $this->weight = ' ';
        $this->dateVerified = ' ';
    }
    static function getAllBiblesByLanguageCodeIso($languageCodeIso){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT * FROM bibles WHERE languageCodeIso = :code 
        ORDER BY volumeName";
        $params = array(':code'=>$languageCodeIso);
        try {
            $statement = $dbConnection->executeQuery($query, $params);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }

    }
    static function updateWeight($bid, $weight){
        $dbConnection = new DatabaseConnection();
        $query = "UPDATE bibles 
            SET weight = :weight
            WHERE bid = :bid
            LIMIT 1";
        $params = array(':weight'=>$weight, 
            ':bid' => $bid, 
        );
        try {
            $dbConnection->executeQuery($query, $params);
            return 'success';
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }


    }
    static function getTextBiblesByLanguageCodeIso($languageCodeIso){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT * FROM bibles 
        WHERE languageCodeIso = :code 
        AND format NOT LIKE :audio AND format NOT LIKE :video AND format != :usx AND format IS NOT NULL
        ORDER BY volumeName";
        $params = array(':code'=>$languageCodeIso, 
            ':audio' => 'audio%', 
            ':video' => 'video%',
            ':usx'=> 'text_usx',
        );
        try {
            $statement = $dbConnection->executeQuery($query, $params);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }

    }
    public function getBestBibleByLanguageCodeIso($code){
        $query = "SELECT * FROM bibles WHERE languageCodeIso = :code ORDER BY weight DESC LIMIT 1";
        $params = array(':code'=>$code);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_OBJ);

            $this->setBibleValues($data);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }

    }
    public function getVolumeName(){
        return $this->volumeName;
    }
     public function selectBibleByBid($bid){
        $query = "SELECT * FROM bibles WHERE bid = :bid LIMIT 1";
        $params = array(':bid'=>$bid);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_OBJ);
            $this->setBibleValues($data);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }

    }
  

    protected function addBibleBrainBible(){
        echo ("external id is $this->externalId<br>");
        $query = "SELECT bid  FROM bibles WHERE externalId = :externalId";
        $params = array(':externalId' => $this->externalId);
        $this->dbConnection = new DatabaseConnection();
        $statement = $this->dbConnection->executeQuery($query, $params);
        $bid = $statement->fetch(PDO::FETCH_COLUMN);
        if (!$bid){
            $query = "INSERT INTO bibles 
            (source, externalId, volumeName, volumeNameAlt, languageCodeIso, 
            languageName, languageEnglish,
            collectionCode,format, audio, text, video, dateVerified) 
            VALUES (:source, :externalId, :volumeName, :volumeNameAlt, 
            :languageCodeIso, :languageName, :languageEnglish,
            :collectionCode,:format,:audio,:text,:video,:dateVerified)";
            $params = array(
                ':source' => $this->source , 
                ':externalId' => $this->externalId , 
                ':volumeName' => $this->volumeName ,
                ':volumeNameAlt' => $this->volumeNameAlt, 
                ':languageCodeIso' => $this->languageCodeIso ,
                ':languageName' => $this->languageName,
                ':languageEnglish' => $this->languageEnglish,
                ':collectionCode' => $this->collectionCode ,':format' => $this->format ,
                ':audio' => $this->audio, ':text' => $this->text ,':video' => $this->video ,
                ':dateVerified' => $this->dateVerified);
            $this->dbConnection->executeQuery($query, $params);
        }
        else{
            writeLogAppend('addBibleBrainBible-foundBid'," $bid  - $this->externalId");
        }

    }
    public function setBibleValues($data){
        if (!$data){
            echo('no data');
            return;
        }
        $this->bid = $data->bid;
        $this->source = $data->source;
        $this->externalId = $data->externalId;
        $this->volumeName = $data->volumeName;
        $this->volumeNameAlt = $data->volumeNameAlt;
        $this->languageCodeHL = $data->languageCodeHL;
        $this->languageName = $data->languageName;
        $this->languageEnglish = $data->languageEnglish;
        $this->languageCodeIso = $data->languageCodeIso;
        $this->idBibleGateway = $data->idBibleGateway;
        $this->collectionCode = $data->collectionCode;
        $this->rightToLeft = $data->rightToLeft;
        $this->numerals = $data->numerals;
        $this->spacePdf = $data->spacePdf;
        $this->noBoldPdf = $data->noBoldPdf;
        $this->format = $data->format;
        $this->text = $data->text;
        $this->audio = $data->audio;
        $this->video = $data->video;
        $this->weight = $data->weight;
        $this->dateVerified = $data->dateVerified;

    }
}
