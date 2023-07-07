<?php
/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/

class BibleBrainLanguageController extends Language {
    private $dbConnection;
    public $languageCodeIso;
    public $response;
    public $LanguageCodeBibleBrain;
    private $glotto_id;
    public $iso;
    public $name;
    public $autonym;
    private $bibles;
    private $filesets;
    private $rolv_code;
    
 


    public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        
    }
    /*This endpoint would be used to find all content available for each Bible for a specific language.
https://4.dbt.io/api/bibles?language_code=HAE&page=1&limit=25
*/
    public function getLanguagesFromCountryCode($countryCode){

        /*
        https://4.dbt.io/api/languages?country=AD&language_code=spa&language_name=spa&include_translations=true&l10n=spa&page=1&limit=25&v=4
    */
        $url = 'https://4.dbt.io/api/languages?country=' . $countryCode;
        $languages =  new BibleBrainConnection($url);
        $this->response = $languages->response;
        
    }


    public function getlanguageDetails($languageCodeIso)
    {  
        $url = 'https://4.dbt.io/api/languages?language_code=' .$languageCodeIso ;
        $languageDetails =  new BibleBrainConnection($url);
        //writeLogDebug('getlanguageDetails-44', $languageDetails);
        if (isset($languageDetails->response)){
            //writeLogDebug('getlanguageDetails-46', $languageDetails->response->data);
            $data = $languageDetails->response->data[0];
           // writeLogDebug('getlanguageDetails-48', $data);
            $this->LanguageCodeBibleBrain = $data->id;
            $this->iso = $data->iso;
            $this->name = $data->name;
            $this->autonym = $data->autonym;
        }
        
    }

    /*[20]=>
  object(stdClass)#26 (8) {
    ["id"]=>
    int(8208)
    ["glotto_id"]=>
    NULL
    ["iso"]=>
    string(3) "cmn"
    ["name"]=>
    string(3) "Hui"
    ["autonym"]=>
    string(15) "回族版圣经"
    ["bibles"]=>
    int(1)
    ["filesets"]=>
    int(12)
    ["rolv_code"]=>
    NULL
  }*/
    function  updateBibleBrainLanguageDetails(){
        if(!$this->LanguageCodeBibleBrain){
            
        }
        $bibleBrainRecordExists = $this->BibleBrainLanguageRecordExists($this->LanguageCodeBibleBrain);
        if (!$bibleBrainRecordExists) {
            $languageIsoRecordExists = parent::LanguageIsoRecordExists($this->iso);
            //echo ("We returned with $languageIsoRecordExists <br>");
            if ($languageIsoRecordExists) {
                //echo ("A LanguageRecord does exist for this iso: $this->iso<br>");
                $found = false;
                $ethnicNames = parent::EthnicNamesForLanguageIso($this->iso);
                foreach ($ethnicNames as $ethnicName) {
                    if ($ethnicName) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    parent::UpdateEthnicNameFromIso($this->iso, $this->autonym);
                }
                parent::UpdateLanguageCodeBibleBrainFromIso($this->iso, $this->LanguageCodeBibleBrain);
                //echo ("Update record for $this->iso <br>");
            } else {
                //echo ("A LanguageRecord does NOT exist for this iso: $this->iso so create one<br>");
                parent::CreateLanguageFromBibleBrainRecord($this);
            }
        }
    }

    protected function BibleBrainLanguageRecordExists($languageCodeBibleBrain)
    {
        $query = 'SELECT id FROM hl_languages WHERE languageCodeBibleBrain = :languageCodeBibleBrain LIMIT 1';
        $params = array(':languageCodeBibleBrain' => $languageCodeBibleBrain);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $id = $statement->fetch(PDO::FETCH_COLUMN);
            return $id;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function BibleBrainLanguageRecordExistsForIso($languageCodeIso)
    {
        $query = 'SELECT languageCodeBibleBrain FROM hl_languages WHERE languageCodeIso = :languageCodeIso LIMIT 1';
        $params = array(':languageCodeIso' => $languageCodeIso);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $id = $statement->fetch(PDO::FETCH_COLUMN);
            return $id;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    
}