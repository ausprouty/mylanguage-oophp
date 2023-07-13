<?php

class DbsBilingualTemplateController2
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
        $file = __DIR__ .'/../templates/bilingualdbs.template2.html';
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
        $template = str_replace('{{Bible Block}}', $biblePassage1->passageText, $template);
        $template = str_replace('||Bible Block||', $biblePassage2->passageText, $template);
        $template = str_replace('{{url}}', $biblePassage1->passageUrl, $template);
        $template = str_replace('||url||', $biblePassage2->passageUrl, $template);
        $template = str_replace('{{Title}}', $this->title, $template);
        writeLogDebug('template', $template);

        $this->template = $template;
    }

}