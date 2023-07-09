<?php

/*
Get list of languages from https://www.faithcomesbyhearing.com/bible-brain-available-content
Download
Open up Excell and then import as UTF-8 text
Save in /imports/data as tab delimited

In Feb 2023 this added 454 languages
*/
$filename = ROOT_IMPORT_DATA . 'BibleBrainLanguageUTF8A.txt';

if (!file_exists($filename)){
    echo $filename;
    echo ('<ul><li>Get <a href="https://www.faithcomesbyhearing.com/bible-brain-available-content">list of languages</a></li>
    <li>Download</li>
    <li>Open up Excell and then import as UTF-8 text</li>
    <li>Save in /imports/data/BibleBrainLanguageUTF8.txtas tab delimited</li>
    <li>Reset Bible Brain Check Date</li>
    <li>Then run this routine again</li>
    <li>I will then fill in the Bible Brain Check Date so that you can update the Language Details</li>
    </ul>');
    return;

}
$datafile = file_get_contents($filename);
$count = 0;
$records = explode("\n", $datafile);
foreach ($records as $record){
    $items = explode ("\t", $record);
    if (!isset($items[1])){
        echo ("finished checking $count languages");
        return;
    }
    $count++;
    $languageCodeIso = $items[0];
    $name = $items[1];
    $language = new BibleBrainLanguageController();
    $language->updateFromLanguageCodeIso($languageCodeIso, $name);

    
}