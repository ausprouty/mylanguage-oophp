<?php

$dbs = new DbsBilingualTemplateController($languageCodeHL1, $languageCodeHL2, $lesson);

$dbsReference= new DbsReference();
$dbsReference->setLesson($lesson);

$bibleReferenceInfo= new  BibleReferenceInfo();
$bibleReferenceInfo->setFromEntry($dbsReference->getEntry());
$testament = $bibleReferenceInfo->getTestament();

$bible1 = new Bible();
$bible1->setBestDbsBibleByLanguageCodeHL($languageCodeHL1, $testament);
$dbs->setBibleOne($bible1);

$bible2 = new Bible();
$bible2->setBestDbsBibleByLanguageCodeHL($languageCodeHL2, $testament);
$dbs->setBibleTwo($bible2);

$dbs->setPassage($bibleReferenceInfo);
$dbs->setBilingualTemplate();
ReturnDataController::returnData($dbs->template);