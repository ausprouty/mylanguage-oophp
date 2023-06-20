<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/
class BibleBrainBibleController extends Bible {

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
        $url .= '&media=text_plain&page=1&limit='. $limit;
        $bibles =  new BibleBrainConnection($url);
        $this->response = $bibles->response;

    }
    public function getFormatTypes(){

        $url = 'https://4.dbt.io/api/bibles/filesets/media/types?v=4';
        $formatTypes =  new BibleBrainConnection($url);
        $this->response = $formatTypes->response;

    }
    public function getDefaultBible($languageCodeIso){
        $url ='https://4.dbt.io/api/bibles/defaults/types?language_code='. $languageCodeIso;
        $bible =  new BibleBrainConnection($url);
        $this->response = $bible->response;
    }
    public function updateBibleDatabaseWithArray(){
        $count = 0;
        $textTypes = array('text_plain', 'text_format', 'text_usx', 'text_html', 'text_json');
        $audioTypes = array('audio_drama', 'audio', 'audio_stream', 'audio_drama_stream');
        $videoTypes = array('video_stream','video');
  
        foreach ($this->response as $translation){
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
                    $this->externalId = $item->id;
                    $this->volumeName = $item->volume;
                    $this->collectionCode = $item->size;
                    $this->dateVerified = date('Y-m-d');
                    $this->source = 'bible_brain';
                    $this->format = $item->type;
                    $this->text = $text;
                    $this->audio = $audio;
                    $this->video = $video;
                    parent::addBibleBrainBible();

                }
            }
           

        }
    }
}