<?php

require_once ( ROOT. 'includes/getElementsByClass.php');
require_once (ROOT . 'libraries/simplehtmldom_1_9_1/simple_html_dom.php');

class BibleGatewayController extends BiblePassage{

    private $bibleReferenceInfo;
    private $bible;
    public  $bibleText;
    public  $passageLink;


    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){

        $this->bibleReferenceInfo=$bibleReferenceInfo;
        $this->bible = $bible;
        $this->bibleText= null;
        $this->passageLink= null;
    }

    public function getExternal(){
        // it seems that Chinese does not always like the way we enter things.// try this and see if it works/
	    $reference_shaped = str_replace(
            $this->bibleReferenceInfo->bookName,
            $this->bibleReferenceInfo->bookID,
            $this->bibleReferenceInfo->entry
        );
	    $reference_shaped = str_replace(' ' , '%20', $reference_shaped);
        $this->passageLink= 'https://biblegateway.com/passage/?search='. $reference_shaped . '&version='. $this->bible->idBibleGateway ;
        $referer = $this->passageLink;
        $webpage = new WebsiteConnection($this->passageLink, $referer);
        if ($webpage->response){
             $this->bibleText =  $this->formatExternal($webpage->response);
        }
        return null;


    }
    private function saveExternal(){
        $id =  $BiblePassage::createBiblePassageId($this->bible->bid, $this->BibleReferenceInfo);
        $newRecord->insertRecord($id, $this->Bibletext);
    }

     private function formatExternal($webpage){
        writeLogDebug('bibleGatewayFormat-42', $webpage);
        $html = str_get_html($webpage);
        $e = $html->find('.dropdown-display-text', 0);
        $reference = $e->innertext;
        $passages = $html->find('.passage-text');
        $bible = '';
        foreach($passages as $passage){
            $bible .= $passage;
        }
        writeLogDebug('bibleGatewayFormat-51', $bible);
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
        $bible = $html->outertext;
        writeLogDebug('bibleGatewayFormat-75', $bible);

        $html = str_get_html($bible);
        $ret = $html->find ('span[class=woj]');
        foreach ($ret as $span){
            $span->outertext= $span->innertext;
        }
        $bible = $html->outertext;
        writeLogDebug('bibleGatewayFormat-82', $bible);
        $html->clear();
        $html = str_get_html($bible);
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
        writeLogDebug('bibleGatewayFormat-111', $bible);
        unset($html);
        $bad= array(
            '<!--end of crossrefs-->'
        );
        $good='';
        $bible= str_replace( $bad, $good, $bible);
        writeLogDebug('bibleGatewayFormat-116', $bible);
        $pos_start = strpos($bible,'<p' );
        if ($pos_start !== FALSE){
            $bible = substr($bible, $pos_start);

            $bible= str_ireplace('</div>', '', $bible);
            $bible= str_ireplace('<div class="passage-other-trans">', '', $bible);
        }
        $output =   "\n" . '<!-- begin bible -->'. $bible   ;
        $output.=  "\n" . '<!-- end bible -->' . "\n";
        return $output;
    }

}