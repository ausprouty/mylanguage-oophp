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
  public $text;
  public $audio;
  public $video;
  public $mobile;
  public $web;
  public $weight;
  public $dateVerified;

   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
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
    public function setBibleValues($data){
        if (!$data){
            echo('no data');
            return;
        }
        $this->bid = $data->bid;
        $this->source = $data->source;
        $this->damId = $data->externalId;
        $this->abbr = $data->abbreviation;
        $this->volumeName = $data->volumeName;
        $this->volumeNameAlt = $data->volumeNameAlt;
        $this->languageCode = $data->languageCode;
        $this->languageCodeHL = $data->languageCodeHL;
        $this->languageName = $data->languageName;
        $this->languageEnglish = $data->languageEnglish;
        $this->languageIso = $data->languageCodeIso;
        $this->languageDrupal = $data->languageCodeDrupal;
        $this->idBibleGateway = $data->idBibleGateway;
        $this->collectionCode = $data->collectionCode;
        $this->rightToLeft = $data->rightToLeft;
        $this->numerals = $data->numerals;
        $this->spacePdf = $data->spacePdf;
        $this->noBoldPdf = $data->noBoldPdf;
        $this->text = $data->text;
        $this->audio = $data->audio;
        $this->video = $data->video;
        $this->mobile = $data->mobile;
        $this->web = $data->web;
        $this->weight = $data->weight;
        $this->dateVerified = $data->dateVerified;

    }
}
