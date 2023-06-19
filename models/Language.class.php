<?php



class Language
{
    private $dbConnection;
    public $id;
    public $name;
    public $ethnicName;
    public $languageCodeBibleBrain;
    public $languageCodeDrupal;
    public $languageCodeHL;
    public $languageCodeIso;
    public $languageCodeBing;
    public $languageCodeBrowser;
    public $languageCodeGoogle;

    public $direction;
    public $numeralSet;

    public $isChinese;
    public $font;

    public function __construct(){
            $this->dbConnection = new DatabaseConnection();
        }

    public function findOneByCode(string $source, string $code){
        $field ='languageCode'.$source;
        $query = 'SELECT * FROM hl_languages WHERE ' .$field .'= :id ';
        $params = array(':id'=> $code );
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_OBJ);
            $this->id = $data->id  ;
            $this->name = $data->name  ;
            $this->ethnicName = $data->ethnicName  ;
            $this->languageCodeBibleBrain = $data->languageCodeBibleBrain  ;
            $this->languageCodeHL = $data->languageCodeHL  ;
            $this->languageCodeIso = $data->languageCodeIso  ;
            $this->languageCodeBing = $data->languageCodeBing  ;
            $this->languageCodeBrowser = $data->languageCodeBrowser  ;
            $this->languageCodeBrowser = $data->languageCodeDrupal  ;
            $this->languageCodeGoogle = $data->languageCodeGoogle  ;
            $this->direction = $data->direction  ;
            $this->numeralSet = $data->numeralSet  ;
            $this->isChinese = $data->isChinese  ;
            $this->font = $data->font  ;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
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
    function  updateBibleBrainLanguage($record){
        if (!$this->BibleBrainRecordExists($record->id)){
            if ($this->LanguageIsoRecordExists($record->iso)){

            }

        }
    }
    private function BibleBrainRecordExists($languageCodeBibleBrain){
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
    private function LanguageIsoRecordExists($languageCodeBibleBrain)
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
}
}