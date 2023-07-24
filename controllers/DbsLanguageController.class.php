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
            echo ("$languageCodeHL<br>");
        }
    }
}
