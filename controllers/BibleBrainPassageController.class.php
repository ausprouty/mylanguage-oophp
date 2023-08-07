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
        $this->setPassageUrl();
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed = 0;
        $this->getExternal();
        $this->formatPassageText();
        $this->setReferenceLocalLanguage();
    }
 

    /* to get verses: https://4.dbt.io/api/bibles/filesets/:fileset_id/:book/:chapter?verse_start=5&verse_end=5&v=4
  */
    public function getExternal()
    {
        $url = 'https://4.dbt.io/api/bibles/filesets/' . $this->bible->getExternalId();
        $url .= '/'. $this->bibleReferenceInfo->getBookID() . '/'. $this->bibleReferenceInfo->getChapterStart();
        $url .= '?verse_start=' . $this->bibleReferenceInfo->getVerseStart() . '&verse_end=' .$this->bibleReferenceInfo->getVerseEnd();
        $passage =  new BibleBrainConnection($url);
        $this->response = $passage->response;
    }
    function setPassageUrl(){
        // https://live.bible.is/bible/engesv/mat/1
        $this->passageUrl = 'https://live.bible.is/bible/'. $this->bible->getExternalId() . '/';
        $this->passageUrl  .= $this->bibleReferenceInfo->getbookID() . '/'. 
            $this->bibleReferenceInfo->getChapterStart();
    }
    function getBibleLanguageName(){
        return $this->bible->languageName;
    }
    function getBibleLanguageEnglish(){
        return $this->bible->languageEnglish;
    }

}

