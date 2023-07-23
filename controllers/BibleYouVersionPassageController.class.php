<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/

class BibleYouVersionPassageController extends BiblePassage {
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
 

    /* to get verses: https://www.bible.com/bible/111/GEN.1.NIV
  */
    public function getExternal()  {
       $uversionBookID =  $this->bibleReferenceInfo->getUversionBookID();
       $book = strtoupper($this->bibleReferenceInfo->bookID) . '.' . $this->bibleReferenceInfo->chapterStart;
       $chapter = str_replace('%', $book , $this->bible->externalId);
       $url = 'https://www.bible.com/bible/'. $chapter;
        writeLogDebug('url', $url);
        $webpage = new WebsiteConnection($url);
        writeLogDebug ('BibleYouVersionPassageController-38', $webpage);
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