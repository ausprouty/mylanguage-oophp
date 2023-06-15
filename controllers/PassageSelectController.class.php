<?php



class PassageSelectController extends BiblePassage
{

    private $bibleReferenceInfo;
    private $bible;
    private $passageId;// used to see if data is stored
    public  $bibleText;
    public  $passageLink;

    public function __construct( BibleReferenceInfo $bibleReferenceInfo, Bible $bible){
            $this->bibleReferenceInfo=$bibleReferenceInfo;
            $this->bible = $bible;
            $this->bibleText= null;
            $this->passageLink= null;
            $this->checkDatabase();
    }
    private function checkDatabase(){
        $this->passageId = BiblePassage::createBiblePassageId($this->bible->bid,  $this->bibleReferenceInfo);
        $passage = new BiblePassage();
        $passage->findStoredById($this->passageId);
        if ($passage->text){
            $this->bibleText= $passage->text;
            print_r("Stored: <br>$this->bibleText <br><br>");
        }
        else{
            $this->bibleText=$this->getExternal();

        }
    }
    private function getExternal(){
        switch($this->bible->source){
            case 'bible_gateway':
                $bibleGateway  = new BibleGatewayController($this->bibleReferenceInfo, $this->bible);
                $this->bibleText = $bibleGateway->bibleText;
                break;
            default:
            break;
        }
            return null;

    }

}