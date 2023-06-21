<?php
$max = 50;
for ($i=0; $i<$max; $i++){

    $bibles = new BibleBrainBibleController();
    $languageCodeIso = $bibles->getNextLanguageforBibleImport();
    $bibles->getBiblesForLanguageIso($languageCodeIso, 10);
    $bibles->updateBibleDatabaseWithArray();
    echo("$languageCodeIso<br>");
    writeLogDebug('bibles-'. $languageCodeIso , $bibles->response);
}