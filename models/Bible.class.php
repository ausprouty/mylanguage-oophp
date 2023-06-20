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
        $this->abbreviation = NULL;
        $this->volumeName = ' ';
        $this->volumeNameAlt = NULL;
        $this->languageCode = ' ';
        $this->languageCodeHL = ' ';
        $this->languageName = ' ';
        $this->languageEnglish = ' ';
        $this->languageCodeIso = ' ';
        $this->languageCodeDrupal = ' ';
        $this->idBibleGateway = ' ';
        $this->collectionCode = ' ';
        $this->rightToLeft = ' ';
        $this->numerals = ' ';
        $this->spacePdf = NULL;
        $this->noBoldPdf = ' ';
        $this->format = '';
        $this->text = ' ';
        $this->audio = NULL;
        $this->video = ' ';

        $this->weight = ' ';
        $this->dateVerified = ' ';
    }

    public function setBestBibleByLanguageCodeHL($code){
        $query = "SELECT * FROM bibles WHERE languageCodeHL = :code ORDER BY weight DESC LIMIT 1";
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
     public function selectBibleByBid($bid){
        $query = "SELECT * FROM bibles WHERE bid = :bid";
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
        echo ("external id is $this->externalId");
        $query = "SELECT bid  FROM bibles WHERE externalId = :externalId";
        $params = array(':externalId' => $this->externalId);
        $this->dbConnection = new DatabaseConnection();
        $statement = $this->dbConnection->executeQuery($query, $params);
        $bid = $statement->fetch(PDO::FETCH_COLUMN);
        if (!$bid){
            $query = "INSERT INTO bibles 
            (source, externalId, volumeName, languageCodeIso, 
            collectionCode,format, text, audio, video, dateVerified) 
            VALUES (:source, :externalId, :volumeName,:languageCodeIso, 
            :collectionCode,:format,:text,:audio,:video,:dateVerified)";
            $params = array(
                ':source' => $this->source , ':externalId' => $this->externalId , 
                ':volumeName' => $this->volumeName ,':languageCodeIso' => $this->languageCodeIso ,
                ':collectionCode' => $this->collectionCode ,':format' => $this->format ,
                ':text' => $this->text ,':audio' => $this->audio ,':video' => $this->video ,
                ':dateVerified' => $this->dateVerified);
            $this->dbConnection->executeQuery($query, $params);
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
        $this->abbreviation = $data->abbreviation;
        $this->volumeName = $data->volumeName;
        $this->volumeNameAlt = $data->volumeNameAlt;
        $this->languageCode = $data->languageCode;
        $this->languageCodeHL = $data->languageCodeHL;
        $this->languageName = $data->languageName;
        $this->languageEnglish = $data->languageEnglish;
        $this->languageCodeIso = $data->languageCodeIso;
        $this->languageCodeDrupal = $data->languageCodeDrupal;
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
