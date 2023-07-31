<?php



class PassageSelectController extends BiblePassage
{

    //private $dbConnection;
    private $bibleReferenceInfo;
    private $bible;
    private $passageId;// used to see if data is stored
    public  $passageText;
    public  $passageUrl;
    public  $referenceLocalLanguage;

    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
        //$this->dbConnection = new DatabaseConnection();
            $this->bibleReferenceInfo=$bibleReferenceInfo;
            $this->bible = $bible;
            $this->passageText= null;
            $this->passageUrl= null;
            $this->checkDatabase();
    }
    private  function checkDatabase(){
        $this->passageId = BiblePassage::createBiblePassageId($this->bible->bid,  $this->bibleReferenceInfo);
        $passage = new BiblePassage();
        $passage->findStoredById($this->passageId);
        if ($passage->referenceLocalLanguage) {
       // if ($passage->passageText){
            $this->passageText= $passage->passageText;
            $this->passageUrl = $passage->passageUrl;
            $this->referenceLocalLanguage = $passage->referenceLocalLanguage;
        }
        else{
            $this->getExternal();
        }
        $this->wrapTextDir();
    }
    private function getExternal(){
        switch($this->bible->source){
            case 'bible_brain':
                $passage = new BibleBrainTextPlainController($this->bibleReferenceInfo, $this->bible);
                $passage->getExternal();
                $passage->showPassageText();
                $this->passageText = $passage->passageText;
                $this->passageUrl = $passage->passageUrl;
                $this->referenceLocalLanguage = $passage->referenceLocalLanguage;
                break;
            case 'bible_gateway':
                $external = new BibleGatewayPassageController($this->bibleReferenceInfo, $this->bible);
                $this->passageText = $external->passageText;
                $this->passageUrl = $external->passageUrl;
                $this->referenceLocalLanguage = $external->referenceLocalLanguage;
                break;
            case 'youversion':
                    $external = new BibleYouVersionPassageController($this->bibleReferenceInfo, $this->bible);
                    $this->passageText = null;
                    $this->passageUrl = $external->passageUrl;
                    writeLogDebug('url', $this->passageUrl);
                    $this->referenceLocalLanguage = $external->referenceLocalLanguage;
                    writeLogDebug('reference',  $this->referenceLocalLanguage);
                    break;    
            case 'word':
                $external = new BibleWordPassageController($this->bibleReferenceInfo, $this->bible);
                $this->passageText = $external->passageText;
                $this->passageUrl = $external->passageUrl;
                $this->referenceLocalLanguage = $external->referenceLocalLanguage;
                break;

            default:
            break;
        }
     if ($this->passageText){
        $this->wrapTextDir();
        parent::savePassageRecord($this->passageId, $this->referenceLocalLanguage,  $this->passageText, $this->passageUrl);
     }
       
        
    }
    private function wrapTextDir(){
        
        if ($this->bible->direction == 'rtl'){
            $dir = 'rtl';
        }
        elseif ($this->bible->direction == 'ltr'){
            $dir = 'ltr';
        }
        else{
            $dir = $this->updateDirection();
        }
        $text = '<div dir="' . $dir . '">' ;
        $text .=  $this->passageText;
        $text .=  '</div>';
        $this->passageText = $text;
    }
    function updateDirection(){
        $languageCodeHL = $this->bible->languageCodeHL;
        $language = new Language();
        $language->findOneByCode('HL', $languageCodeHL);
        $direction = $language->getDirection();
        $dir = 'ltr';
        if ($direction == 'rtl'){
            $dir = 'rtl';
        }
        $dbConnection = new DatabaseConnection();
        $query = "UPDATE bibles
            SET direction = :dir
            WHERE languageCodeHL = :languageCodeHL";
        $params = array(
            ':languageCodeHL'=>  $languageCodeHL,
            ':dir'=> $dir
        );
        $statement = $dbConnection->executeQuery($query, $params);
        return $dir;
    }

}