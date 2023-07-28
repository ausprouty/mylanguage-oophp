<?php
writeLogDebug('dbsBilingual', "$languageCodeHL1, $languageCodeHL2, $lesson");

$dbs = new DbsBilingualTemplateController($languageCodeHL1, $languageCodeHL2, $lesson);

$bible1 = new Bible();
$bible1->setBestBibleByLanguageCodeHL($languageCodeHL1);
$dbs->setBibleOne($bible1);


$bible2 = new Bible();
$bible2->setBestBibleByLanguageCodeHL($languageCodeHL2);
$dbs->setBibleTwo($bible2);


$dbsReference= new DbsReference();
$dbsReference->getLesson($lesson);
$bibleReferenceInfo= new  BibleReferenceInfo();
$bibleReferenceInfo->importPublic($dbsReference->bibleReferenceInfo);

$dbs->setPassage($bibleReferenceInfo);
$dbs->getBilingualTemplate();
writeLogDebug('line20', $dbs->template) ;
ReturnDataController::returnData($dbs->template);