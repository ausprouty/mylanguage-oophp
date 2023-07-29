<?php



class BibleWordPassageController extends BiblePassage {

    private $bibleReferenceInfo;
    private $bible;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
 
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
       $dir = ROOT_RESOURCES . '/bibles/wordproject/';
       $externalId = $this->bible->externalId;
       $bibleDir = $dir .  $externalId. '/'.  $externalId . '/';
       $bookNumber =  $this->bibleReferenceInfo->bookNumber;
       if (intval( $bookNumber)<10){
        $bookNumber = '0' .  $bookNumber;
       }
       $chapterNumber = $this->bibleReferenceInfo->chapterStart;
       $fileName= $bibleDir .  $bookNumber . '/'.  $chapterNumber;
       writeLogDebug('BibleWordPassageController-35', $fileName);
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
        writeLogDebug('BibleWordPassageController-48', $webpage);
        $cleanPage = $this->cleanPage($webpage);
        $bibleText = $this->selectVerses($cleanPage);
        $output =   "\n" . '<!-- begin bible -->'; 
        $output .=  $bibleText ."\n" . '<!-- end bible -->' . "\n" ;
        $this->passageText = $output;
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
    private function createLocalReference($websiteReference){
        $expectedInReference = $this->bibleReferenceInfo->chapterStart . ':' .
            $this->bibleReferenceInfo->verseStart . '-' . $this->bibleReferenceInfo->verseEnd;
        if (strpos($websiteReference, $expectedInReference) == FALSE){
            $lastSpace =strrpos($websiteReference, ' ');
            $websiteReference = substr($websiteReference,0, $lastSpace) .' '. $expectedInReference;
        }
        $this->referenceLocal =$websiteReference;
    }

}