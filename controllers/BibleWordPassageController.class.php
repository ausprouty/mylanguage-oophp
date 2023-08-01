<?php



class BibleWordPassageController extends BiblePassage {

    private $bibleReferenceInfo;
    private $bible;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
 
        $this->bibleReferenceInfo=$bibleReferenceInfo;
        $this->bible = $bible;
        $this->referenceLocalLanguage = '';
        $this->passageText = '';
        $this->passageUrl = '';
        $this->dateLastUsed = '';
        $this->dateChecked = '';
        $this->timesUsed = 0;
        $this->getExternal();
    }
 

    public function getExternal(){
       $dir = ROOT_RESOURCES . '/bibles/wordproject/';
       $externalId = $this->bible->externalId;
       $bibleDir = $dir .  $externalId. '/'.  $externalId . '/';
       $bookNumber =  $this->bibleReferenceInfo->bookNumber;
       if (intval( $bookNumber)<10){
        $bookNumber = '0' .  $bookNumber;
       }
       $chapterNumber = $this->bibleReferenceInfo->chapterStart;
       $fileName= $bibleDir .  $bookNumber . '/'.  $chapterNumber;
       $webpage = null;
       if (file_exists ($fileName . '.html')){
            $webpage = file_get_contents($fileName . '.html');
       }
       elseif (file_exists ($fileName . '.htm')){
            $webpage = file_get_contents($fileName . '.htm');
        }
       if ($webpage){
            $this->formatExternal($webpage);
       }
    }

    private function formatExternal($webpage){
        $cleanPage = $this->cleanPage($webpage);
        $this->passageText =   "\n" . '<!-- begin bible -->';
        $this->passageText .=   $this->selectVerses($cleanPage) ."\n" ;
        $this->passageText .=  '<!-- end bible -->' . "\n" ;
        $this->referenceLocalLanguage = $this->createReferenceLocalLanguage($cleanPage);
    }
    private function cleanPage($webpage){
        $find = '<!--... the Word of God:-->'; // trim off front
        $pos = strpos($webpage, $find) + strlen($find);
        $webpage = substr($webpage, $pos);
        $find = '<!--... sharper than any twoedged sword... -->'; // trim off end
        $pos = strpos($webpage, $find);
        $clean = substr($webpage, 0,  $pos);
        return $clean;

    }
    private function selectVerses($page){
        $text = '';
        $firstVerse = intval($this->bibleReferenceInfo->verseStart);
        $lastVerse = intval($this->bibleReferenceInfo->verseEnd);
        $bad = array('<p>', '</p>');
        $page = str_replace($bad, '', $page);
        $bad = array ('<br/>', '<br />');
        $page = str_replace( $bad, '<br>', $page);
        $lines = explode('<br>', $page);
        foreach ($lines as $line){
            $posStart = strpos($line, '>') +1;
            $find = '</span>';
            $posEnd = stripos($line, $find);
            $length = $posEnd - $posStart;
            $verseNum = intval(substr($line, $posStart, $length));
            if ($verseNum >= $firstVerse && $verseNum <= $lastVerse ){
                $text .= '<p><sup>'.$verseNum . '</sup>';
                $text .= substr($line, $posEnd + strlen($find));
                $text .= '</p>' . "\n";
            }
        }
        return $text;
    }
    private function createReferenceLocalLanguage($cleanPage){
        $expectedInReference = $this->bibleReferenceInfo->chapterStart . ':' .
            $this->bibleReferenceInfo->verseStart . '-' . $this->bibleReferenceInfo->verseEnd;
        writeLogDebug('expected', $expectedInReference);
        writeLogDebug('cleanPage', $cleanPage);
        //if (strpos($websiteReference, $expectedInReference) == FALSE){
        //    $lastSpace =strrpos($websiteReference, ' ');
        //    $websiteReference = substr($websiteReference,0, $lastSpace) .' '. $expectedInReference;
        //}
       // $this->referenceLocalLanguage = $websiteReference;
    }

}