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

        $url = 'https://4.dbt.io/api/bibles?language_code=';
        $url .=  strtoupper($languageCodeIso) ;
        $url .= '&media=text_plain&page=1&limit='. $limit;
        $bibles =  new BibleBrainConnection($url);
        $this->response = $bibles->response;
    
        /*$dbp_prod = 'dbp-prod';
        $dbp_vid ='dbp-vid';
        foreach ($resources as $resource){
            $output .= $resource->abbr . ': '. $resource->vname . '(' . $resource->name. ')<br>';
            if (isset($resource->filesets->$dbp_prod)){
                $items = $resource->filesets->$dbp_prod;
                foreach ( $items as $item){
                    $output .= '----------' .$item->id . '(' . $item->type. ')'. $item->size . '<br>';
                }
            }
            if (isset($resource->filesets->$dbp_vid)){
                $items = $resource->filesets->$dbp_vid;
                foreach ( $items as $item){
                    $output .= '----------' .$item->id . '(' . $item->type. ')'. $item->size . '<br>';
                }
            }
        }
        return $output;
        */
    }
    public function getFileTypes(){

        $url = 'https://4.dbt.io/api/bibles/filesets/media/types?v=4';
        $fileTypes =  new BibleBrainConnection($url);
        $this->response = $fileTypes->response;

    }
    public function getDefaultBible($languageCodeIso){
        $url ='https://4.dbt.io/api/bibles/defaults/types?language_code='. $languageCodeIso;
        $bible =  new BibleBrainConnection($url);
        $this->response = $bible->response;
    }
}