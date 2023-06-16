<?php

// upgrade BiblePassages to separate reference and link

class BiblePassagesUpgrade extends BiblePassage
{

    private $dbConnection;
    public function __construct() {
        $this->dbConnection = new DatabaseConnection();
        $query = "SELECT * FROM bible_passages WHERE dateChecked is NULL LIMIT 1";
        $statement = $this->dbConnection->executeQuery($query, $params = []);
        $data = $statement->fetch(PDO::FETCH_OBJ);
        if ($data) {
            $this->bpid = $data->bpid;
            $this->referenceLocal = $data->referenceLocal;
            $this->passageText = $data->passageText;
            $this->passageUrl = $data->passageUrl;
            $this->dateLastUsed = $data->dateLastUsed;
            $this->dateChecked = $data->dateChecked;
            $this->timesUsed = $data->timesUsed;
        }

    }
// <br><hr><a href="http://www.bible.is/TGLTAB/Luke/1" external="1">Read More</a><br><br>
    public function findURL(){
        $text = $this->passageText;
        if (strpos($text, '<a' ) !== false){
            $pos_start_a= strpos($text, '<a');
            $pos_start_url=strpos($text, 'http', $pos_start_a);
            $pos_end_url=strpos($text, '"', $pos_start_url);
            $pos_end_a= strpos ($text, '</a>', $pos_start_a);
            $length_a= $pos_end_a - $pos_start_a +4;
            $length_url=$pos_end_url - $pos_start_url;
            $link = substr($text, $pos_start_a, $length_a);
            $this->passageUrl=substr($text, $pos_start_url, $length_url);
            echo ("$this->bpid <br>Found a Link<br>$link <br><br> $this->passageUrl<br><br>");
            $this->passageText =str_replace($link, '', $text);
            parent::updatepassageText();
            parent::updatePassageUrl();
        }else{
            echo ("$this->bpid<br>NO LINK<br>");
        }
        parent::updateDateChecked();

    }
    public function findReference()
    {
        $bpid = explode('-', $this->bpid);
        $reference="$bpid[2]:$bpid[3]-$bpid[4]";
        $text = $this->passageText;
        if (strpos($text, $reference)){
            // <b><p>लूका 1:1-80</b></p>
            $strPosReference = strpos($text, $reference);
            $lengthBegin = strlen($reference) + $strPosReference ;
            $begin = substr($text, 0,  $lengthBegin );
            $endB = $endP = 0;
            if (strpos($begin, '<b>' !== false)){
                $endB = strpos($text, '</b>');
            }
            if (strpos($begin, '<p>' !== false)){
                $endP = strpos($text, '</p>');
            }
            $larger = $endB;
            if ($endP > $endB){
                $larger = $endP;
            }
            $larger = $larger +4;  // to get end of string
            $preface = substr($text, 0, $larger);
            $bad = array('<b>', '<p>');
            $this->referenceLocal = str_replace($bad, '', $begin);
            $this->passageText = str_replace($preface, '', $text);
            echo ("$this->bpid <br>and now reference: $this->referenceLocal<br><br>");
            parent::updateReferenceLocal();
            parent::updateText();
          
        }
        else{
            echo ("$this->bpid <br>No referencel<br><br>$this->passageText");
        }
        parent::updateDateChecked();
    }
}