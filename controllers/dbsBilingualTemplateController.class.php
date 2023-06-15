<?php

class DbsBilingualTemplateController
{
    public   $template;
    private  $translation1;
    private  $translation2;
    private  $bible1;
    private  $bible2;
    private  $bibleReferenceInfo;

    public function __construct( string $languageCodeHL1, string $languageCodeHL2)
    {   $translation1 = new Translation($languageCodeHL1, 'dbs');
        $this->translation1=  $translation1->translation;
        $translation2 = new Translation($languageCodeHL2, 'dbs');
        $this->translation2= $translation2->translation;
        $this->template= ' ';

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
        print_r($this->bible1);
       // print_r($this->bibleReferenceInfo);
        $biblePassage1= new PassageSelectController ($this->bibleReferenceInfo, $this->bible1);
        print_r($biblePassage1);
echo('<BR><BR>');
        $bibleText1= $biblePassage1->bibleText;
//print_r($bibleText1);
        $biblePassage2= new PassageSelectController ($this->bibleReferenceInfo, $this->bible2);
        $template= str_replace ('{{Bible Block}}', $bibleText1, $template);
        $bibleText2 = $biblePassage2->bibleText;
        $this->template= str_replace ('||Bible Block||', $bibleText2, $template);
        return $this->template;
    }
}