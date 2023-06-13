<?php



class PassageSelectController extends BiblePassage
{
    private $dbConnection;
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
        print_r ($this->passageId );
        $passage = new BiblePassage();
        $passage->findStoredById($this->passageId);
        if ($passage->text){
            $this->bibleText= $passage->text;
        }
        else{
            $this->bibleText=$this->getExternal();
        }
    }
    private function getExternal(){
        switch($this->bible->source){
            case 'bible-gateway':
                $this->bibleText = new BibleGatewayController($this->dateLastUsedbibleReferenceInfo, $this->bible);
                break;
            default:
            break;
        }
            return null;

    }

}