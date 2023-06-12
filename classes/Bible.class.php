<?php


class Bible {
  private  $dbConnection;
  private $bid;
  private $source;
  private $externalId;
  private $abbreviation;
  private $volumeName;
  private $volumeNameAlt;
  private $languageCode;
  private $languageCodeHL;
  private $languageName;
  private $languageEnglish;
  private $languageCodeIso;
  private $languageCodeDrupal;
  private $versionCode;
  private $collectionCode;
  private $rightToLeft;
  private $numerals;
  private $spacePdf;
  private $noBoldPdf;
  private $text;
  private $audio;
  private $video;
  private $mobile;
  private $web;
  private $weight;
  private $dateVerified;

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
    private function setBibleValues($data){
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
        $this->versionCode = $data->versionCode;
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
