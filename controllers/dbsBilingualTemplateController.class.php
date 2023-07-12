<?php

class DbsBilingualTemplateController
{
    private  $bible1;
    private  $bible2;
    private  $bibleReferenceInfo;
    private  $biblePassageText1;
    private  $biblePassageText2;
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
        $language1 = new Language;
        $language1-> findOneByCode('HL' , $languageCodeHL1);
        $this->language1 = $language1->getName();
        $language2 = new Language;
        $language2-> findOneByCode('HL' , $languageCodeHL2);
        $this->language2 = $language2->getName();
        $title = new DbsReference();
        $title->getLesson($lesson);
        $this->title = $title->description;

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
    }
    public function getBilingualTemplate()
    {
        $file = __DIR__ .'/../templates/bilingualdbs.template.html';
        if (!file_exists($file)){
            return null;
        }
        $template = file_get_contents($file);
        foreach ($this->translation1 as $key => $value){
            $find= '{{' . $key . '}}';
            $template= str_replace ($find, $value, $template);
        }
        foreach ($this->translation2 as $key => $value){
            $find= '||' . $key . '||';
            $template= str_replace ($find, $value, $template);
        }
        $template = str_replace('{{language}}', $this->language1, $template);
        $template = str_replace('||language||', $this->language2, $template);

        $biblePassage1= new PassageSelectController ($this->bibleReferenceInfo, $this->bible1);
        $biblePassage2= new PassageSelectController ($this->bibleReferenceInfo, $this->bible2);
        $template = str_replace('{{Bible Reference}}', $biblePassage1->referenceLocal, $template);
        $template = str_replace('||Bible Reference||', $biblePassage2->referenceLocal, $template);
        $template = str_replace('{{url}}', $biblePassage1->passageUrl, $template);
        $template = str_replace('||url||', $biblePassage2->passageUrl, $template);
        $template = str_replace('{{Title}}', $this->title, $template);
      
        $bibleBlock = $this->createBiblePassageRows($biblePassage1->passageText, $biblePassage2->passageText);
        writeLogDebug('bibleBlock',  $bibleBlock);
        $template= str_replace ('{{Bible Block}}', $bibleBlock, $template);
        writeLogDebug('template', $template);

        $this->template = $template;
    }
    private function createBiblePassageRows($passageText1, $passageText2){
        $paragraphs1 = $this->findParagraphs($passageText1);
        $paragraphs2 = $this->findParagraphs($passageText2);
        $bibleBlock = '';
        writeLogDebug('paragraphs1', $paragraphs1);
        writeLogDebug('paragraphs2', $paragraphs2);
        $length1 = count($paragraphs1) -1;
        $length2 = count($paragraphs2) -1;
        $key1 = 0;
        $key2 = 0;
        $nextColumn1Verse = 0;
        $nextColumn2Verse = 0;
        $newRow = true;
        while ($nextColumn1Verse != 999999 && $nextColumn2Verse != 999999 ){
            if ($newRow){
                $column1 = '<td class="ltr dbs">' . $paragraphs1[$key1]->text;
                $column2 = '<td class="ltr dbs">' . $paragraphs2[$key2]->text;
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
                $bibleBlock .= '<tr class="ltr dbs">' . "\n";
                $bibleBlock .= "$column1\n";
                $bibleBlock .= "$column2\n";
                $bibleBlock .= "</tr>\n";
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
        writeLogDebug('bibleBlock', $bibleBlock);
        return $bibleBlock;
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