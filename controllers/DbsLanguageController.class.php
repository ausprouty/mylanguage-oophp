<?php

class DbsLanguageController{

    public function updateDatabase(){
        $directory = ROOT_TRANSLATIONS . 'languages/';
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        foreach ($scanned_directory as $languageCodeHL){
            $bible = Bible::getBestBibleByLanguageCodeHL($languageCodeHL);
            if (!$bible) {
                continue;
            }
            if ($bible->weight != 9){
                continue;
            }
            if ($bible->source == 'youversion'){
                $format = 'link';
            }
            else{
                $format = 'text';
            }
            $collectionCode = $bible->collectionCode;
            $dbs = new  DbsLanguage($languageCodeHL, $collectionCode, $format);
        }
    }
    public function getOptions(){
        $dbConnection = new DatabaseConnection();
        $query = "SELECT dbs_languages.*, hl_languages.name,  hl_languages.ethnicName
                  FROM dbs_languages INNER JOIN hl_languages
                  ON dbs_languages.languageCodeHL = hl_languages.languageCodeHL";
        try {
            $statement = $dbConnection->executeQuery($query);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
