<?php



class PassageSelectController extends BiblePassage
{

    //private $dbConnection;
    protected $bibleReferenceInfo;
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
    public function getBible(){
        return $this->bible;
    }
    public function getBibleDirection(){
        return $this->bible->direction;
    }
    public function getBibleBid(){
        return $this->bible->bid;
    }
    public function getBibleReferenceInfo(){
        return $this->bibleReferenceInfo;
    }
    private  function checkDatabase(){
        $this->passageId = BiblePassage::createBiblePassageId($this->bible->bid,  $this->bibleReferenceInfo);
        $passage = new BiblePassage();
        $passage->findStoredById($this->passageId);
        if ($passage->getReferenceLocalLanguage()) {
            writeLogAppend('using Stored', $this->bible->bid);
            $this->passageText= $passage->getPassageText();
            $this->passageUrl = $passage->getPassageUrl();
            $this->referenceLocalLanguage = $passage->getReferenceLocalLanguage();
        }
        else{
            $this->getExternal();
            writeLogAppend('using external', $this->bible->bid);
        }
        writeLogAppend('referenceLocalLanguage', $this->referenceLocalLanguage);
        $this->wrapTextDir();
    }
    private function getExternal(){
        switch($this->bible->source){
            case 'bible_brain':
                $passage = new BibleBrainTextPlainController($this->bibleReferenceInfo, $this->bible);
                writeLogAppend('using bible brain', $this->bible->bid);
                break;
            case 'bible_gateway':
                $passage = new BibleGatewayPassageController($this->bibleReferenceInfo, $this->bible);
                break;
            case 'youversion':
                $passage = new BibleYouVersionPassageController($this->bibleReferenceInfo, $this->bible);
                writeLogDebug('youversion', $passage);
                break;    
            case 'word':
                $passage = new BibleWordPassageController($this->bibleReferenceInfo, $this->bible);
                break;
            default:
            break;
        }
        $this->passageText = $passage->getPassageText();
        $this->passageUrl = $passage->getPassageUrl();
        $this->referenceLocalLanguage = $passage->getReferenceLocalLanguage();
        writeLogAppend('getExternal', $this->referenceLocalLanguage);
        parent::savePassageRecord($this->passageId, $this->referenceLocalLanguage,  $this->passageText, $this->passageUrl); 
    }
    private function wrapTextDir(){
        if ($this->passageText == NULL){
            return;
        }
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
    private function updateDirection(){
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