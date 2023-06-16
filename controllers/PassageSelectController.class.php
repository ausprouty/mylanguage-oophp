<?php



class PassageSelectController extends BiblePassage
{

    //private $dbConnection;
    private $bibleReferenceInfo;
    private $bible;
    private $passageId;// used to see if data is stored
    public  $passageText;
    public  $passageUrl;
    public $referenceLocal;

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
        echo ("$this->passageId <br>");
        $passage->findStoredById($this->passageId);
        if ($passage->passageText){
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
            case 'bible_gateway':
                $external = new BibleGatewayController($this->bibleReferenceInfo, $this->bible);
                $this->passageText = $external->passageText;
                $this->passageUrl = $external->passageURL;
                $this->referenceLocal = $external->referenceLocal;

                break;
            default:
            break;
        }



    }

}