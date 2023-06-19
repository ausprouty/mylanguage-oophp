<?php

/*
Get list of languages from https://www.faithcomesbyhearing.com/bible-brain-available-content
Download
Open up Excell and then import as UTF-8 text
Save in /imports/data as tab delimited

In Feb 2023 this added 454 languages
*/
$filename = ROOT . 'imports/data/BibleBrainLanguageUTF8.txt';
$datafile = file_get_contents($filename);

$records = explode("\n", $datafile);
foreach ($records as $record){
    $items = explode ("\t", $record);
    $languageCodeIso = $items[0];
    $name = str_replace('"', '', $items[1]);
    $dbConnection = new DatabaseConnection();
    $query = 'SELECT id FROM hl_languages 
        WHERE languageCodeIso = :languageCodeIso LIMIT 1';
    $params = array(':languageCodeIso' => $languageCodeIso);
    $statement = $dbConnection->executeQuery($query, $params);
    $id = $statement->fetch(PDO::FETCH_COLUMN);
    if (!$id){
        $languageCodeHL = $languageCodeIso . '23';
        $query = 'INSERT INTO hl_languages (languageCodeHL,  languageCodeIso, name) 
        VALUES (:languageCodeHL, :languageCodeIso, :name)';
        $params = array(':languageCodeHL' => $languageCodeHL,
                        ':languageCodeIso' => $languageCodeIso,
                        'name' => $name);
        $statement = $dbConnection->executeQuery($query, $params);
        
    }
}