<?php

$code = 'eng00';
$entry = 'John 3:16-18';
$bibleInfo = new Bible();
$bibleInfo->getBestBibleByLanguageCodeHL($code);
$referenceInfo = new  BibleReferenceInfo();
$referenceInfo->setFromPassage($entry);
$passage = new PassageSelectController($referenceInfo, $bibleInfo);
echo ('YOu should see the URL and text of John 3:16-18 below<hr>');
print_r($passage->getPassageUrl());
print_r($passage->getPassageText());
