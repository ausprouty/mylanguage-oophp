<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/

class BibleYouVersionPassageController extends BiblePassage {

    private $bibleReferenceInfo;
    private $bible;
    public $response;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
      
        $this->bibleReferenceInfo = $bibleReferenceInfo;
        $this->bible = $bible;
        $this->referenceLocalLanguage = 'unknown';
        $this->passageText = '';
        $this->setPassageUrl();
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed = 0;
        
    }
 
    private function setPassageUrl(){
        $uversionBibleBookID =  $this->bibleReferenceInfo->getUversionBookID(); //GEN
        $bibleBookAndChapter =   $uversionBibleBookID . '.' . $this->bibleReferenceInfo->chapterStart . '.'; // GEN.1.
        $bibleBookAndChapter .=   $this->bibleReferenceInfo->verseStart . '-'. $this->bibleReferenceInfo->verseEnd ; // GEN.1
        $chapter = str_replace('%', $bibleBookAndChapter , $this->bible->externalId); // 11/%.NIV   => /111/GEN.1.NIV
        $this->passageUrl = 'https://www.bible.com/bible/'. $chapter;
        writeLogDebug('setPassageUrl-32', $this->passageUrl);
    }
    /* to get verses: https://www.bible.com/bible/111/GEN.1.7-14.NIV

    https://www.bible.com/bible/37/GEN.1.7-14.CEB
  */
    public function getExternal()  {
        $uversionBibleBookID =  $this->bibleReferenceInfo->getUversionBookID(); //GEN
        $bibleBookAndChapter =   $uversionBibleBookID . '.' . $this->bibleReferenceInfo->chapterStart . '.'; // GEN.1.
        $bibleBookAndChapter .=   $this->bibleReferenceInfo->verseStart . '-'. $this->bibleReferenceInfo->verseEnd ; // GEN.1
        $chapter = str_replace('%', $bibleBookAndChapter , $this->bible->externalId); // 11/%.NIV   => /111/GEN.1.NIV
        $url = 'https://www.bible.com/bible/'. $chapter;
        $webpage = new WebsiteConnection($url);
    }

    private function formatExternalText($webpage){
        //todo: we are not yet using this.  We are using reference instead
        $begin = '<div class="ChapterContent_label';
        $end = '<div class="ChapterContent_version-copyright';
    }
    public function getPassageText(){
        return $this->passageText;
    }
    public function getPassageUrl(){
        writeLogDebug('getPassageUrl-56', $this->passageUrl);
        return $this->passageUrl;
    }
    public function getReferenceLocalLanguage(){
        return $this->referenceLocalLanguage;
    }
 
    
  
}