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

        $biblePassage1= new PassageSelectController ($this->bibleReferenceInfo, $this->bible1);
        $biblePassage2= new PassageSelectController ($this->bibleReferenceInfo, $this->bible2);
        $template = str_replace('{{Bible Reference}}', $biblePassage1->referenceLocal, $template);
        $template = str_replace('||Bible Reference||', $biblePassage2->referenceLocal, $template);
        $template = str_replace('{{url}}', $biblePassage1->passageUrl, $template);
        $template = str_replace('||url||', $biblePassage2->passageUrl, $template);

        $template= str_replace ('{{Bible Block}}', $biblePassage1->bibleText, $template);
        $template = str_replace ('||Bible Block||', $biblePassage2->bibleText, $template);
        $this->template = $template;
        return $this->template;
    }
}