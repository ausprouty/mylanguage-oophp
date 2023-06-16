<?php



class PassageSelectController extends BiblePassage
{

    //private $dbConnection;
    private $bibleReferenceInfo;
    private $bible;
    private $passageId;// used to see if data is stored
    public  $bibleText;
    public  $passageUrl;
    public $referenceLocal;

    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
        //$this->dbConnection = new DatabaseConnection();
            $this->bibleReferenceInfo=$bibleReferenceInfo;
            $this->bible = $bible;
            $this->bibleText= null;
            $this->passageUrl= null;
            $this->checkDatabase();
    }
    private function checkDatabase(){
        $this->passageId = BiblePassage::createBiblePassageId($this->bible->bid,  $this->bibleReferenceInfo);
        $passage = new BiblePassage();
        $passage->findStoredById($this->passageId);
        if ($passage->text){
            $this->bibleText= $passage->text;
            $this->passageUrl = $passage->passageUrl;
        }
        else{
            $this->bibleText=$this->getExternal();
        }
    }
    private function getExternal(){
        switch($this->bible->source){
            case 'bible_gateway':
                $external = new BibleGatewayController($this->bibleReferenceInfo, $this->bible);
                $this->bibleText = $external->bibleText;
                $this->passageUrl = $external->passageURL;
                echo ("url is  $this->passageUrl");
                $this->referenceLocal = $external->referenceLocal;

                break;
            default:
            break;
        }



    }

}