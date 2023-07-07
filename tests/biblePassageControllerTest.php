<?php

$code = 'eng00';
$entry = 'John 3:16-18';
$bibleInfo = new Bible();
$bibleInfo->getBestBibleByLanguageCodeHL($code);
$referenceInfo = new  BibleReferenceInfo();
$referenceInfo->setFromPassage($entry);
$passage = new BiblePassageExternalController($referenceInfo, $bibleInfo);
print_r($passage->getPassageLink());
print_r($passage->getPassageText());
