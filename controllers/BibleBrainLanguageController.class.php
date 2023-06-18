<?php


class BibleBrainLanguageController extends Bible {
    private $dbConnection;
    public $languageCodeIso;
    public $response;


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
    
    }