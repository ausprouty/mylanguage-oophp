<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/

class BibleBrainPassageController extends BiblePassage {
    private $dbConnection;
    protected $bibleReferenceInfo;
    protected $bible;
    public $response;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
        $this->dbConnection = new DatabaseConnection();
        $this->bibleReferenceInfo = $bibleReferenceInfo;
        $this->bible = $bible;
        $this->referenceLocalLanguage = '';
        $this->passageText = '';
        // https://live.bible.is/bible/engesv/mat/1
        $this->passageUrl = 'https://live.bible.is/bible/'. $this->bible->externalId . '/';
        $this->passageUrl  .= $this->bibleReferenceInfo->bookID . '/'. $this->bibleReferenceInfo->chapterStart;
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed = 0;
        $this->getExternal();
    }
 

    /* to get verses: https://4.dbt.io/api/bibles/filesets/:fileset_id/:book/:chapter?verse_start=5&verse_end=5&v=4
  */
    public function getExternal()
    {
        $url = 'https://4.dbt.io/api/bibles/filesets/' . $this->bible->externalId;
        $url .= '/'. $this->bibleReferenceInfo->bookID . '/'. $this->bibleReferenceInfo->chapterStart;
        $url .= '?verse_start=' . $this->bibleReferenceInfo->verseStart . '&verse_end=' .$this->bibleReferenceInfo->verseEnd;
        $passage =  new BibleBrainConnection($url);
        $this->response = $passage->response;
    }
    public function getPassageText(){
        return $this->passageText;
    }
    public function getPassageUrl(){
        return this->passageUrl;
    }

    
  
}