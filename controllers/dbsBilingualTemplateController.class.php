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
    {
        $this->translation1= new Translation($languageCodeHL1, 'dbs');
        $this->translation2=new Translation($languageCodeHL2, 'dbs');
        $this->template= null;
        $this->bible1=null;
        $this->bible2= null;
        $this->bibleReferenceInfo= null;
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
        $text = file_get_contents($file);

        foreach ($this->translation1 as $key => $value){
            $find= '{{' . $key . '}}';
            $template= str_replace ($find, $value, $template);
        }
        foreach ($this->translation2 as $key => $value){
            $find= '||' . $key . '||';
            $template= str_replace ($find, $value, $template);
        }
        $biblePassage1= new PassageSelectController ($this->bibleReferenceInfo, $this->bible1);
        $biblePassage2= new PassageSelectController ($this->bibleReferenceInfo, $this->bible2);
        $template= str_replace ('{{Bible Block}}', $biblePassage1, $template);
        $this->template= str_replace ('||Bible Block||', $biblePassage2, $template);
    }
}