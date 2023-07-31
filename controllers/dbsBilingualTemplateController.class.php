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
        $file = __DIR__ .'/../templates/bilingualdbs.template.html';
        if (!file_exists($file)){
            return null;
        }
        $this->template = file_get_contents($file);
        $this->template = str_replace('{{language}}', $this->language1->getName(),$this->template);
        $this->template = str_replace('||language||', $this->language2->getName(),$this->template);
        $this->template = str_replace('{{Bible Reference}}', $this->biblePassage1->referenceLocalLanguage,$this->template);
        $this->template = str_replace('||Bible Reference||', $this->biblePassage2->referenceLocalLanguage,$this->template);
        $this->template = str_replace('{{url}}', $this->biblePassage1->passageUrl, $this->template);
        $this->template = str_replace('||url||', $this->biblePassage2->passageUrl, $this->template);
        $this->template = str_replace('{{Title}}', $this->title,$this->template);
        
        $this->createBibleBlock();
        writeLogDebug('bibleBlock',  $this->bibleBlock);
        $this->template= str_replace ('{{Bible Block}}', $this->bibleBlock, $this->template);
        $this->template= str_replace ('{{dir_language1}}', $this->language1->getDirection(),$this->template);
        $this->template= str_replace ('||dir_language2||', $this->language2->getDirection(),$this->template);
       
        foreach ($this->translation1 as $key => $value){
            $find= '{{' . $key . '}}';
            $this->template= str_replace ($find, $value,$this->template);
        }
        foreach ($this->translation2 as $key => $value){
            $find= '||' . $key . '||';
            $this->template= str_replace ($find, $value,$this->template);
        }
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
        $text1 = 
        $text2 = $this->showTextOrLink2();
        $this->bibleBlock = '<tr  class="{{dir_language1}} dbs">' . "\n";
        $this->bibleBlock .= $this->showTextOrLink1();
        $this->bibleBlock .= $this->showTextOrLink2();
        $this->bibleBlock .= '</tr>' . "\n";
        writeLogDebug('line 108', $this->bibleBlock);
    }
    private function showTextOrLink1(){
        if (strlen($this->biblePassage1->passageText) <22){
            return '<td  class="{{dir_language1}} dbs bible">' . 
                '<a href="' . $this->biblePassage1->passageUrl . '">{{Read Passage}}</a>' .
                '</td>' . "\n";
        }
        else{
            return '<td  class="{{dir_language1}} dbs bible" style="width:80%">' . 
                     $this->biblePassage1->passageText . 
                     '</td>' . "\n";
        }
    }
    private function showTextOrLink2(){
        if (strlen($this->biblePassage2->passageText) <22){
            return '<td  class="||dir_language2|| dbs bible">' . 
                '<a href="' . $this->biblePassage2->passageUrl . '">||Read Passage||</a>' .
                '</td>' . "\n";
        }
        else{
            return '<td  class="||dir_language2|| dbs bible" style="width:80%">' . 
                     $this->biblePassage2->passageText . 
                     '</td>' . "\n";
        }
    }

    private function createBiblePassageRows(){
        $paragraphs1 = $this->findParagraphs($this->biblePassage1->passageText);
        $paragraphs2 = $this->findParagraphs($this->biblePassage2->passageText);
        $this->bibleBlock = '';
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
                $this->bibleBlock .= '<tr class="{{dir_language1}} dbs">' . "\n";
                $this->bibleBlock .= "$column1\n";
                $this->bibleBlock .= "$column2\n";
                $this->bibleBlock .= "</tr>\n";
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
        return $this->bibleBlock;
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