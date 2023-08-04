<?php



class BibleGatewayPassageController extends BiblePassage {

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
        /* it seems that Chinese does not always like the way we enter things.// try this and see if it works/
	    $reference_shaped = str_replace(
            $this->bibleReferenceInfo->bookName,
            $this->bibleReferenceInfo->bookID,
            $this->bibleReferenceInfo->entry
        );
        $reference_shaped = str_replace(' ', '%20', $reference_shaped);
*/
	    $reference_shaped = str_replace(' ' , '%20', $this->bibleReferenceInfo->entry);
        $this->passageUrl= 'https://biblegateway.com/passage/?search='. $reference_shaped . '&version='. $this->bible->externalId ;
        $webpage = new WebsiteConnection($this->passageUrl);
        if ($webpage->response){
            $this->passageText =  $this->formatExternal($webpage->response);
        }
        else{
            $this->passageText = '';
        }
    }
    private function formatExternal($webpage){
        require_once('./libraries/simplehtmldom_1_9_1/simple_html_dom.php');
        $html = str_get_html($webpage);
        $e = $html->find('.dropdown-display-text', 0);
        $this->createLocalReference($e->innertext);
        $passages = $html->find('.passage-text');
        $bible = '';
        foreach($passages as $passage){
            $bible .= $passage;
        }
        $html->clear();
        unset($html);
        //
        // now we are working just with Bible text
        //

        $html = str_get_html($bible);
        $ret = $html->find ('span');
        foreach ($ret as $span){
            $span->outertext= $span->innertext;
        }
        // remove all links
        $ret = $html->find ('a');
        foreach ($ret as $href){
            $href->outertext= '';
        }
        // remove footnotes
        $ret= $html->find('div[class=footnotes]');
        foreach ($ret as $footnote){
            $footnote->outertext= '';
        }

        $html = str_get_html($bible);
        $ret = $html->find ('span[class=woj]');
        foreach ($ret as $span){
            $span->outertext= $span->innertext;
        }
        $bible = $html->outertext;
        $html->clear();
        $html = str_get_html($bible);
        // remove read chapter
        
        $ret= $html->find('a[class=full-chap-link]');
        foreach ($ret as $footnote){
            $footnote->outertext= '';
        }

        // remove  footnotes div
        $ret= $html->find('div[class=footnotes]');
        foreach ($ret as $footnote){
            $footnote->outertext= '';
        }
        // remove links to footnotes
        $ret= $html->find('sup[class=footnote]');
        foreach ($ret as $footnote){
            $footnote->outertext= '';
        }
        // remove crossreference div
        $ret= $html->find('div[class=crossrefs hidden]');
        foreach ($ret as $cross_reference){
            $cross_reference->outertext= '';
        }
        $ret= $html->find('sup[class=crossreference]');
        foreach ($ret as $cross_reference){
            $cross_reference->outertext= '';
        }
        $ret= $html->find('div[class=il-text]');
        foreach ($ret as $cross_reference){
            $cross_reference->outertext= '';
        }
        // change chapter number to verse 1
        // <span class="chapternum">53&nbsp;</span>
        $ret= $html->find('span[class=chapternum]');
        foreach ($ret as $chapter){
            $chapter->outertext= '<sup class="versenum">1&nbsp;</sup>';
        }
        $bible = $html->outertext;
        unset($html);
        $bad= array(
            '<!--end of crossrefs-->'
        );
        $good='';
        $bible= str_replace( $bad, $good, $bible);
        $pos_start = strpos($bible,'<p' );
        if ($pos_start !== FALSE){
            $bible = substr($bible, $pos_start);

            $bible= str_ireplace('</div>', '', $bible);
            $bible= str_ireplace('<div class="passage-other-trans">', '', $bible);
        }
        $output =   "\n" . '<!-- begin bible -->'; 
        $output .= $bible  ."\n" . '<!-- end bible -->' . "\n" ;

        return $output;
    }
    private function createLocalReference($websiteReference){
        $expectedInReference = $this->bibleReferenceInfo->chapterStart . ':' .
            $this->bibleReferenceInfo->verseStart . '-' . $this->bibleReferenceInfo->verseEnd;
        if (strpos($websiteReference, $expectedInReference) == FALSE){
            $lastSpace =strrpos($websiteReference, ' ');
            $websiteReference = substr($websiteReference,0, $lastSpace) .' '. $expectedInReference;
        }
        $this->referenceLocalLanguage =$websiteReference;
    }

}