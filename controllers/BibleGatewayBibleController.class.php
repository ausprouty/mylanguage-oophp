<?php

class BibleGatewayBibleController{

/*

    In Feb 2023 this added 454 languages
    */
    private  $languageCodeIso;
    private  $externalId;
    private  $bibleName;

    public function import(){
        $filename = ROOT_IMPORT_DATA . 'BibleGatewayBibles.txt';

        if (!file_exists($filename)){
            echo $filename;
            echo (`View source of <a href="https://www.biblegateway.com"</a>and create list of Bibles as follows:
            <pre>
            <option class="lang" value="BG1940">---Български (BG)---</option>
            <option value="BG1940" >1940 Bulgarian Bible (BG1940)</option>
            <option value="BULG" >Bulgarian Bible (BULG)</option>
            <option value="ERV-BG" >Bulgarian New Testament: Easy-to-Read Version (ERV-BG)</option>
            <option value="CBT" >Библия, нов превод от оригиналните езици (с неканоничните книги) (CBT)</option>
            <option value="BOB" >Библия, синодално издание (BOB)</option>
            <option value="BPB" >Библия, ревизирано издание (BPB)</option>
            <option class="spacer" value="BPB">&nbsp;</option>
            </pre>`);
            return;

        }
        $datafile = file_get_contents($filename);
        $count = 0;
        $languageCodeIso = '';
        $lines = explode("\n", $datafile);
        foreach ($lines as $line){
            if (strpos($line, 'class="lang"') !== FALSE){
                $languageCodeIso = $this->setLanguageCodeIso($line);
            }
            elseif  (strpos($line, 'class="spacer"') == FALSE){
                $this->setExternalId($line);
                $new = $this->updateDatabase($line);
                if ($new){
                    $count++;
                }
            }
        }
        return $count;
    }
    private function setLanguageCodeIso($line){
        $pos_last = strrpos($line, '(');
        $new = substr($line, $pos_last);
        $pos_last = strpos($new, ')')-1;
        $new = substr($new, 1, $pos_last);
        $this->langugeIsoCode= strtolower($new);
    }
    private function setExternalId($line){
        $pos = strpos($line, '>') +1;
        $new = substr($line, $pos);
        $pos = strpos($new, '<') -1;
        $new = substr($new, 0, $pos);
        $pos = strrpos($new, '(');
        $this->bibleName = trim(substr($new, 0, $pos-1));
        $this->externalId = substr($new, $pos +1);

    }
    private function updateDatabase(){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT bid FROM bibles 
            WHERE source = :biblegateway AND
            externalId = :externalId LIMIT 1";
        $params = array(':biblegateway'=>'bible_gateway', 
            ':externalId' => $this->externalId, 
        );
        try {
            $statement = $dbConnection->executeQuery($query, $params);
            $bid = $statement->fetch(PDO::FETCH_COLUMN);
            if ($bid){
                writeLogAppend('found', $this->externalId);
            }
            else{
                writeLogAppend('notfound', $this->externalId);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }


    }
}