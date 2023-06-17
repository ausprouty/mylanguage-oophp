<?php


}

class DbtBibleController extends BiblePassage {
    private $dbConnection;
    private $bibleReferenceInfo;
    private $bible;


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
 

    public function getExternal(){
        
   

}