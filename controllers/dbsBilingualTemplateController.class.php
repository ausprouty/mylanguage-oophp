<?php

class DbsBilingualTemplateController
{
    private  $bible1;
    private  $bible2;
    private  $bibleBlock;
    private  $biblePassage1;
    private  $biblePassage2;
    private  $bibleReferenceInfo;
    private  $language1;
    private  $language2;
    public   $template;
    private  $title;
    private  $translation1;
    private  $translation2;
   
   

    public function __construct( string $languageCodeHL1, string $languageCodeHL2, $lesson)
    {   $translation1 = new Translation($languageCodeHL1, 'dbs');
        $this->translation1=  $translation1->translation;
        $translation2 = new Translation($languageCodeHL2, 'dbs');
        $this->translation2= $translation2->translation;
        $this->template= ' ';
        $this->language1 = new Language;
        $this->language1-> findOneByCode('HL' , $languageCodeHL1);
        $this->language2 = new Language;
        $this->language2-> findOneByCode('HL' , $languageCodeHL2);
        $dbsReference = new DbsReference();
        $dbsReference->setLesson($lesson);
        $this->title = $dbsReference->getDescription();
        $this->bibleBlock = '';
        $this->biblePassage1 = '';
        $this->biblePassage2 = '';

    }

    public function setBibleOne(Bible $bible)
    {
        $this->bible1=$bible;
    }
    public function setBibleTwo(Bible $bible)
    {
        $this->bible2=$bible;
    }
    public function setPassage(BibleReferenceInfo $bibleReferenceInfo)
    {
        $this->bibleReferenceInfo=$bibleReferenceInfo;
        $this->biblePassage1= new PassageSelectController ($this->bibleReferenceInfo, $this->bible1);
        $this->biblePassage2= new PassageSelectController ($this->bibleReferenceInfo, $this->bible2);
    }
    public function getBilingualTemplate()
    {
        $file = ROOT_TEMPLATES . 'bilingualDbs.template.html';
        if (!file_exists($file)){
            return null;
        }
        $this->template = file_get_contents($file);
        $this->createBibleBlock();
        $this->template= str_replace ('{{Bible Block}}', $this->bibleBlock, $this->template);
        $this->template = str_replace('{{language}}', $this->language1->getName(),$this->template);
        $this->template = str_replace('||language||', $this->language2->getName(),$this->template);
        $this->template = str_replace('{{Bible Reference}}', $this->biblePassage1->referenceLocalLanguage,$this->template);
        $this->template = str_replace('||Bible Reference||', $this->biblePassage2->referenceLocalLanguage,$this->template);
        $this->template = str_replace('{{url}}', $this->biblePassage1->passageUrl, $this->template);
        $this->template = str_replace('||url||', $this->biblePassage2->passageUrl, $this->template);
        $this->template = str_replace('{{Bid}}', $this->bible1->bid, $this->template);
        $this->template = str_replace('||Bid||', $this->bible2->bid, $this->template);
        $this->template = str_replace('{{Title}}', $this->title,$this->template);
        $this->template= str_replace ('{{dir_language1}}', $this->language1->getDirection(),$this->template);
        $this->template= str_replace ('||dir_language2||', $this->language2->getDirection(),$this->template);
        writeLogDebug('template-73', $this->template);
        foreach ($this->translation1 as $key => $value){
            $find= '{{' . $key . '}}';
            $this->template= str_replace ($find, $value,$this->template);
        }
        foreach ($this->translation2 as $key => $value){
            $find= '||' . $key . '||';
            $this->template= str_replace ($find, $value,$this->template);
        }
        writeLogDebug('template-82', $this->template);
    }

    private function createBibleBlock(){
        // a blank record is <div dir="ltr"></div>
        if (strlen($this->biblePassage1->passageText) >  22 
            && strlen($this->biblePassage2->passageText) > 22){
            $this->createBiblePassageRows();
        }
        else{
            $this->createBibleBlockWhenTextMissing();
        }
    }

    private function createBibleBlockWhenTextMissing(){
        $this->bibleBlock = '';
        if (strlen($this->biblePassage2->passageText) > strlen($this->biblePassage1->passageText)){
            $this->bibleBlock .= $this->showTextOrLink($this->biblePassage1);
            $this->bibleBlock .= $this->showTextOrLink($this->biblePassage2);
        }
        else{
            $this->bibleBlock .= $this->showTextOrLink($this->biblePassage2);
            $this->bibleBlock .= $this->showTextOrLink($this->biblePassage1);
        }
        writeLogDebug('whenTextMissing',$this->bibleBlock );
    }
    private function showTextOrLink($biblePassage){
        if (strlen($biblePassage->passageText) <22){
            return $this->showDivLink($biblePassage); 
        }else{
            return $this->showDivText($biblePassage);
        }
    }
    private function showDivLink($biblePassage){
        writeLogDebug('showDivLink', $biblePassage);
        writeLogDebug('showDivLinkBible', $biblePassage->getBible());
        $template = file_get_contents(ROOT_TEMPLATES . 'bibleBlockDivLink.template.html');
        $existing = array(
            '{{dir_language}}',
            '{{url}}',
            '{{Bible Reference}}',
            '{{Bid}}'
        );
        $new = array(
            $biblePassage->getBibleDirection(),
            $biblePassage->passageUrl,
            $biblePassage->referenceLocalLanguage,
            $biblePassage->getBibleBid()
        );
        $template = str_replace($existing, $new, $template);
        writeLogAppend('showDivLink', $template);
        return $template;

    }
    private function showDivText($biblePassage){
        writeLogDebug('showDivText', $biblePassage);
        writeLogDebug('showDivTextBible', $biblePassage->getBible());
        $template = file_get_contents(ROOT_TEMPLATES . 'bibleBlockDivText.template.html');
        $existing = array(
            '{{dir_language}}',
            '{{url}}',
            '{{Bible Reference}}',
            '{{Bid}}',
            '{{passage_text}}'
        );
        $new = array(
            $biblePassage->getBibleDirection(),
            $biblePassage->passageUrl,
            $biblePassage->referenceLocalLanguage,
            $biblePassage->getBibleBid(),
            $biblePassage->getPassageText()
        );
        $template = str_replace($existing, $new, $template);
        writeLogAppend('showDivText', $template);
        return $template;
    }
 

    private function createBiblePassageRows(){
        $file = ROOT_TEMPLATES . 'bibleBlockTable.template.html';
        if (!file_exists($file)){
            return null;
        }
        $template = file_get_contents($file);
        $paragraphs1 = $this->findParagraphs($this->biblePassage1->passageText);
        $paragraphs2 = $this->findParagraphs($this->biblePassage2->passageText);
        $passageRows = '';
        $length1 = count($paragraphs1) -1;
        $length2 = count($paragraphs2) -1;
        $key1 = 0;
        $key2 = 0;
        $nextColumn1Verse = 0;
        $nextColumn2Verse = 0;
        $newRow = true;
        while ($nextColumn1Verse != 999999 && $nextColumn2Verse != 999999 ){
            if ($newRow){
                $column1 = '<td class=""{{dir_language1}} dbs">' . $paragraphs1[$key1]->text;
                $column2 = '<td class="||dir_language2|| dbs">' . $paragraphs2[$key2]->text;
                $newRow = false;
            }
            if ($key1 < $length1){
                $nextColumn1Verse = $paragraphs1[$key1 +1]->verseNumber;
            }
            else{
                $nextColumn1Verse = 999999;
            }
            if ($key2 < $length2){
                $nextColumn2Verse = $paragraphs2[$key2 +1]->verseNumber;
            }
            else{
                $nextColumn2Verse = 999999;
            }
            if ($nextColumn1Verse ==  $nextColumn2Verse ){
                $column1 .= '</td>';
                $column2 .= '</td>';
                $passageRows .= '<tr class="{{dir_language1}} dbs">' . "\n";
                $passageRows  .= "$column1\n";
                $passageRows  .= "$column2\n";
                $passageRows  .= "</tr>\n";
                $key1++;
                $key2++;
                $newRow = true;
            }
            if ($nextColumn1Verse >  $nextColumn2Verse ){
                $key2++;
                if ($key2 <= $length2){
                    $column2 .= $paragraphs2[$key2]->text;
                }
            }
            if ($nextColumn1Verse <  $nextColumn2Verse ){
                $key1++;
                if ($key1 <= $length1){
                    $column1 .= $paragraphs1[$key1]->text;
                }
            }
        }
        $this->bibleBlock = str_replace('{passage_rows}', $passageRows, $template);
        writeLogDebug('bibleBlock-218',$this->bibleBlock);
    }

    private function findParagraphs($text){
        $lines = explode('<p', $text);
        $rows = array();
        foreach ($lines as $index=> $line){
            $obj = new stdClass();
            $obj->text = '<p' . $line;
            if (strpos ($obj->text, '</p>') == false){
                $obj->text = null;
            }
            $obj->verseNumber = $this->firstVerse($line);
            $rows[$index] = $obj;
        }
        return $rows;
        
    }
    private function firstVerse($line){
        $posEnd = strpos($line, '</sup');
        if (!$posEnd){
            return null;
        }
        $short = substr($line, 0, $posEnd);
        $posStart = strrpos($short, '>') +1;
        $firstVerse = substr($short, $posStart);
        $bad = array('&nbsp;', ' ');
        $firstVerse = str_replace($bad, '', $firstVerse);
        return intval($firstVerse);
    }
}