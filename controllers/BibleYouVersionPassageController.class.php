<?php

/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/

class BibleYouVersionPassageController extends BiblePassage {

    private $bibleReferenceInfo;
    private $bible;
    public $response;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
        $this->bibleReferenceInfo=$bibleReferenceInfo;
        $this->bible = $bible;
        $this->referenceLocalLanguage = '';
        $this->passageText = '';
        $this->passageUrl = $this->getPassageUrl();
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed = 0;
        
    }
 
    public function getPassageUrl(){
        $uversionBibleBookID =  $this->bibleReferenceInfo->getUversionBookID(); //GEN
        $bibleBookAndChapter =   $uversionBibleBookID . '.' . $this->bibleReferenceInfo->chapterStart . '.'; // GEN.1.
        $bibleBookAndChapter .=   $this->bibleReferenceInfo->verseStart . '-'. $this->bibleReferenceInfo->verseEnd ; // GEN.1
        $chapter = str_replace('%', $bibleBookAndChapter , $this->bible->externalId); // 11/%.NIV   => /111/GEN.1.NIV
        $this->passageUrl = 'https://www.bible.com/bible/'. $chapter;
        return $this->passageUrl;
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

        // todo: so set it here
    }

    private function formatExternalText($webpage){
        $begin = '<div class="ChapterContent_label';
        $end = '<div class="ChapterContent_version-copyright';
    }
    public function showPassageText(){
        return $this->passageText;
    }
    public function getProtectedPassageText(){
        $response = $this->getPassageText();
        return $response;
    }
    
  
}