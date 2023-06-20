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
    protected function CreateLanguageFromBibleBrainRecord($record){
        $languageCodeHL = $record->iso . '23';
        if ($record->name == NULL){
            writeLogAppend ('ERROR - CreateLanguageFromBibleBrainRecord', $record);
            $record->name = ' ';
        }
        $query = 'INSERT INTO hl_languages (languageCodeHL,  languageCodeIso, name, ethnicName, languageCodeBibleBrain) 
        VALUES (:languageCodeHL, :languageCodeIso, :name, :ethnicName, :languageCodeBibleBrain)';
        $params = array(
            ':languageCodeHL' => $languageCodeHL,
            ':languageCodeIso' => $record->iso,
            ':name' => $record->name,
            ':ethnicName'=> $record->autonym, 
            ':languageCodeBibleBrain'=> $record->id
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);

    }
    protected function LanguageIsoRecordExists($languageCodeIso)
    {
        $query = 'SELECT id FROM hl_languages WHERE languageCodeIso = :languageCodeIso LIMIT 1';
        $params = array(':languageCodeIso' => $languageCodeIso);
        try {
            $this->dbConnection = new DatabaseConnection();
            $statement = $this->dbConnection->executeQuery($query, $params);
            $id = $statement->fetch(PDO::FETCH_COLUMN);
            return $id;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    protected function EthnicNamesForLanguageIso($languageCodeIso)
    {
        $query = 'SELECT ethnicName FROM hl_languages WHERE languageCodeIso = :languageCodeIso';
        $params = array(':languageCodeIso' => $languageCodeIso);
        try {
            $this->dbConnection = new DatabaseConnection();
            $statement = $this->dbConnection->executeQuery($query, $params);
            $ethnicNames = $statement->fetchALL(PDO::FETCH_COLUMN);
            return $ethnicNames;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    protected function UpdateEthnicNameFromIso($languageCodeIso, $ethnicName){
        $query = 'UPDATE hl_languages SET ethnicName = :ethnicName 
             WHERE languageCodeIso = :languageCodeIso';
        $params = array(':languageCodeIso' => $languageCodeIso, ':ethnicName'=> $ethnicName
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }
    protected function UpdateLanguageCodeBibleBrainFromIso($languageCodeIso, $languageCodeBibleBrain)
    {
        $query = 'UPDATE hl_languages SET languageCodeBibleBrain = :languageCodeBibleBrain 
             WHERE languageCodeIso = :languageCodeIso';
        $params = array(
            ':languageCodeIso' => $languageCodeIso, ':languageCodeBibleBrain' => $languageCodeBibleBrain
        );
        $this->dbConnection = new DatabaseConnection();
        $this->dbConnection->executeQuery($query, $params);
    }
}
