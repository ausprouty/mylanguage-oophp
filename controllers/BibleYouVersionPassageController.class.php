<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/

class BibleBrainPassageController extends BiblePassage {
    private $dbConnection;
    private $bibleReferenceInfo;
    private $bible;
    public $response;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
        $this->dbConnection = new DatabaseConnection();
        $this->bibleReferenceInfo=$bibleReferenceInfo;
        $this->bible = $bible;
        $this->referenceLocal = '';
        $this->passageText = '';
        $this->passageUrl = '';
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed = 0;
        $this->getExternal();
    }
 

    /* to get verses: https://4.dbt.io/api/bibles/filesets/:fileset_id/:book/:chapter?verse_start=5&verse_end=5&v=4
  */
    public function getExternal()
    {
       $url = 'https://www.bible.com/bible/'. $this->bible->externalId;
       $url .= '/'. $this->bibleReferenceInfo->bookID . '/'. $this->bibleReferenceInfo->chapterStart;
        writeLogDebug('url', $url);
        $passage =  new BibleYouVersionConnection($url);
        writeLogDebug('passage', $passage);
        $this->response = $passage->response;
        writeLogDebug ('BibleBrainPassageController-38- response', $this->response);
        // todo: so set it here
    }
    public function showPassageText(){
        return $this->passageText;
    }
    public function getProtectedPassageText(){
        $response = $this->getPassageText();
        writeLogDebug('getProtectedPassageText', $response);
        return $response;
    }
    
  
}