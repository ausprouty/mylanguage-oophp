<?php



class PassageSelectController extends BiblePassage
{

    //private $dbConnection;
    private $bibleReferenceInfo;
    private $bible;
    private $passageId;// used to see if data is stored
    public  $passageText;
    public  $passageUrl;
    public  $referenceLocal;

    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
        //$this->dbConnection = new DatabaseConnection();
            $this->bibleReferenceInfo=$bibleReferenceInfo;
            $this->bible = $bible;
            $this->passageText= null;
            $this->passageUrl= null;
            $this->checkDatabase();
    }
    private function checkDatabase(){
        $this->passageId = BiblePassage::createBiblePassageId($this->bible->bid,  $this->bibleReferenceInfo);
        $passage = new BiblePassage();
        $passage->findStoredById($this->passageId);
        if ($passage->referenceLocal) {
       // if ($passage->passageText){
            $this->passageText= $passage->passageText;
            $this->passageUrl = $passage->passageUrl;
            $this->referenceLocal = $passage->referenceLocal;
        }
        else{
            $this->getExternal();
        }
    }
    private function getExternal(){
        switch($this->bible->source){
            case 'bible_brain':
                $external = new BibleBrainPassageController($this->bibleReferenceInfo, $this->bible);
                $this->passageText = $external->passageText;
                $this->passageUrl = $external->passageUrl;
                $this->referenceLocal = $external->referenceLocal;
                break;
            case 'bible_gateway':
                $external = new BibleGatewayPassageController($this->bibleReferenceInfo, $this->bible);
                $this->passageText = $external->passageText;
                $this->passageUrl = $external->passageUrl;
                $this->referenceLocal = $external->referenceLocal;
                break;
            default:
            break;
        }
     if ($this->passageText){
        parent::savePassageRecord($this->passageId, $this->referenceLocal,  $this->passageText, $this->passageUrl);
     }
       
        
    }

}