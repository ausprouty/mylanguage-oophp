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
}