<?php

$dbs = new DbsBilingualTemplateController($languageCodeHL1, $languageCodeHL2, $lesson);

$bible1 = new Bible();
$bible1->setBestBibleByLanguageCodeHL($languageCodeHL1);
$dbs->setBibleOne($bible1);

$bible2 = new Bible();
$bible2->setBestBibleByLanguageCodeHL($languageCodeHL2);
$dbs->setBibleTwo($bible2);

$dbsReference= new DbsReference();
$dbsReference->setLesson($lesson);

$bibleReferenceInfo= new  BibleReferenceInfo();
$bibleReferenceInfo->setFromEntry($dbsReference->getEntry());

$dbs->setPassage($bibleReferenceInfo);
$dbs->getBilingualTemplate();
ReturnDataController::returnData($dbs->template);