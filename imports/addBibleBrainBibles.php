<?php
$languageCodeIso = 'ahk';
$bibles = new BibleBrainBibleController();
$bibles->getBiblesForLanguageIso($languageCodeIso, 5);
$bibles->updateBibleDatabaseWithArray();
echo($languageCodeIso);
writeLogDebug('bibles-'. $languageCodeIso , $bibles->response);