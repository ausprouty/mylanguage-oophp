<?php



class Language
{
    private $id;
    private $name;
    private $ethnicName;
    private $languageCodeBibleBrain;
    private $languageCodeDrupal;
    private $languageCodeHL;
    private $languageCodeIso;
    private $languageCodeBing;
    private $languageCodeBrowser;
    private $languageCodeGoogle;
    private $direction;
    private $numeralSet;
    private $isChinese;
    private $font;

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
            if ($data) {
                $this->id = $data->id  ;
                $this->name = $data->name  ;
                $this->ethnicName = $data->ethnicName  ;
                $this->languageCodeBibleBrain = $data->languageCodeBibleBrain  ;
                $this->languageCodeHL = $data->languageCodeHL  ;
                $this->languageCodeIso = $data->languageCodeIso  ;
                $this->languageCodeBing = $data->languageCodeBing  ;
                $this->languageCodeBrowser = $data->languageCodeBrowser  ;
                $this->languageCodeDrupal = $data->languageCodeDrupal  ;
                $this->languageCodeGoogle = $data->languageCodeGoogle  ;
                $this->direction = $data->direction  ;
                $this->numeralSet = $data->numeralSet  ;
                $this->isChinese = $data->isChinese  ;
                $this->font = $data->font  ;
            }
            
            return $data;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }

    }
   

   
    static function getCodeIsoFromCodeHL ($languageCodeHL){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT languageCodeIso
            FROM hl_languages
            WHERE languageCodeHL = :languageCodeHL
            LIMIT 1";
        $params = array(':languageCodeHL'=>$languageCodeHL);
        try {
            $statement = $dbConnection->executeQuery($query, $params);
            $languageCodeIso = $statement->fetch(PDO::FETCH_COLUMN);
            return $languageCodeIso;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }


    }
    public function getName() {
        return $this->name;
    }

    public function getEthnicName() {
        return $this->ethnicName;
    }

    public function getLanguageCodeBibleBrain() {
        return $this->languageCodeBibleBrain;
    }

    public function getLanguageCodeHL() {
        return $this->languageCodeHL;
    }

    public function getLanguageCodeIso() {
        return $this->languageCodeIso;
    }

    public function getLanguageCodeBing() {
        return $this->languageCodeBing;
    }

    public function getLanguageCodeBrowser() {
        return $this->languageCodeBrowser;
    }

    public function getLanguageCodeDrupal() {
        return $this->languageCodeDrupal;
    }

    public function getLanguageCodeGoogle() {
        return $this->languageCodeGoogle;
    }

    public function getDirection() {
        return $this->direction;
    }

    public function getNumeralSet() {
        return $this->numeralSet;
    }

    public function getIsChinese() {
        return $this->isChinese;
    }

    public function getFont() {
        return $this->font;
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
