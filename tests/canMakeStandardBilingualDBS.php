<?php
echo ('YOu should see a Bilingual Bible study for English and French Lesson 3<hr>');
$lang1 ='eng00';
$lang2= 'frn00';
$lesson = 3;


$dbs = new DbsBilingualTemplateController($lang1, $lang2);

$bible1 = new Bible();
$bible1->getBestBibleByLanguageCodeHL($lang1);
$dbs->setBibleOne($bible1);

$bible2 = new Bible();
$bible2->getBestBibleByLanguageCodeHL($lang2);
$dbs->setBibleTwo($bible2);

$dbsReference= new DbsReference();
$dbsReference->getLesson($lesson);
$bibleReferenceInfo= new  BibleReferenceInfo();
$bibleReferenceInfo->importPublic($dbsReference->bibleReferenceInfo);

$dbs->setPassage($bibleReferenceInfo);
$output= $dbs->getBilingualTemplate();

echo ($output);
