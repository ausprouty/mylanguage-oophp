<?php
$max = 50;
echo ("You should see the languageCodeIso below that you are importing Bibles for<br>");
echo ("This routine is driven by the values of checkedBBBibles in hl_languages <hr>");
for ($i=0; $i<$max; $i++){
    $bibles = new BibleBrainBibleController();
    $languageCodeIso = $bibles->getNextLanguageforBibleImport();
    if ($languageCodeIso == NULL){
        echo ('I am finished  please set checkedBBBibles in hl_languages to NULL if you want to restart');
        return;
    }
    $bibles->getBiblesForLanguageIso($languageCodeIso, 10);
    $bibles->updateBibleDatabaseWithArray();
    echo("$languageCodeIso<br>");
    writeLogDebug('bibles-'. $languageCodeIso , $bibles->response);
}