<?php

$maxImport = 50;
$filename = ROOT . 'imports/data/BibleBrainLanguageUTF8.txt';
$datafile = file_get_contents($filename);
$records = explode("\n", $datafile);
$count = 0;
foreach ($records as $record){
    $items = explode ("\t", $record);
    $languageCodeIso = $items[0];
    $languageDetails = new  BibleBrainLanguageController();
    if (!$languageDetails->BibleBrainLanguageRecordExistsForIso($languageCodeIso)){
       // echo ("$languageCodeIso does not have Bible Brain Info<br>");
        $languageDetails->getlanguageDetails($languageCodeIso);
        $languageDetails->updateBibleBrainLanguageDetails();
        echo ("$languageCodeIso <br>");
        $count++;
    }
   if ($count >  $maxImport){
        break;
    }
}
