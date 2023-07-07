<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/
class BibleBrainBibleController extends Bible {
    private $dbConnection;
    public $languageCodeIso;
    public $response;


    public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        
    }
    /*This endpoint would be used to find all content available for each Bible for a specific language.
https://4.dbt.io/api/bibles?language_code=HAE&page=1&limit=25
*/
    public function getBiblesForLanguageIso($languageCodeIso, $limit){
        $this->languageCodeIso = $languageCodeIso;
        $url = 'https://4.dbt.io/api/bibles?language_code=';
        $url .=  strtoupper($languageCodeIso) ;
        $url .= '&page=1&limit='. $limit;
        $bibles =  new BibleBrainConnection($url);
        $this->response = $bibles->response;
        writeLogDebug ('getBiblesForLanguageIso',$this->response);

    }
    public function showResponse(){
        return $this->response;
    }
    public function getFormatTypes(){
        $url = 'https://4.dbt.io/api/bibles/filesets/media/types?';
        $formatTypes =  new BibleBrainConnection($url);
        $this->response = $formatTypes->response;
        return $formatTypes->response;;

    }
    public function getDefaultBible($languageCodeIso){
        $url ='https://4.dbt.io/api/bibles/defaults/types?language_code='. $languageCodeIso;
        $bible =  new BibleBrainConnection($url);
        $this->response = $bible->response;
    }
    public function getNextLanguageforBibleImport(){
        $query = "SELECT languageCodeIso FROM hl_languages 
            WHERE languageCodeBibleBrain IS NOT NULL
            AND checkedBBBibles IS NULL LIMIT 1";
    
        $this->dbConnection = new DatabaseConnection();
        $statement = $this->dbConnection->executeQuery($query);
        $languageCodeIso = $statement->fetch(PDO::FETCH_COLUMN);
        $this->languageCodeIso = $languageCodeIso;
        return $languageCodeIso;
      

    }
    public function updateBibleDatabaseWithArray(){
        writeLogDebug('updateBibleDatabaseWithArray- ' . $this->languageCodeIso, $this->response);
        $count = 0;
        $audioTypes = array('audio_drama', 'audio', 'audio_stream', 'audio_drama_stream');
        $textTypes = array('text_plain', 'text_format', 'text_usx', 'text_html', 'text_json');
        $videoTypes = array('video_stream','video');
  
        foreach ($this->response as $translation){
            $this->languageName = $translation->autonym;
            $this->languageEnglish = $translation->language;
            $this->languageCodeIso = $translation->iso;
            $this->volumeName = $translation->name;
            $this->volumeNameAlt = $translation->vname;

            foreach ($translation->filesets as $fileset){
                writeLogDebug('updateBibleDatabaseWithArray'. $count, $fileset);
                $count++;
                $text=0;
                $audio=0;
                $video=0;
                foreach ($fileset as $item){
                    if (in_array($item->type, $textTypes)){
                        $text = 1;
                    }
                    if (in_array($item->type, $audioTypes)) {
                        $audio = 1;
                    }
                    if (in_array($item->type, $videoTypes)) {
                        $video = 1;
                    }
                    $this->source = 'bible_brain';
                    $this->externalId = $item->id;
                    if ($item->volume){
                        $this->volumeName = $item->volume; 

                    }
                    $this->collectionCode = $item->size;
                    $this->dateVerified = date('Y-m-d');
                    $this->format = $item->type;
                    $this->text = $text;
                    $this->audio = $audio;
                    $this->video = $video;
                    parent::addBibleBrainBible();
                }
            }
        }
        $query = "UPDATE  hl_languages 
           SET checkedBBBibles = :today 
           WHERE languageCodeIso = :languageCodeIso";
        $params = [':today'=> date('Y-m-d'), ':languageCodeIso'=> $this->languageCodeIso];
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }
}