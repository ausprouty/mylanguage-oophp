<?php

$code = 'eng00';
$entry = 'John 3:16-18';
$bibleInfo = new Bible();
$bibleInfo->setBestBibleByLanguageCodeHL($code);
$referenceInfo = new  BibleReferenceInfo();
$referenceInfo->setFromPassage($entry);
$passage = new BiblePassageExternalController($referenceInfo, $bibleInfo);
print_r($passage->passageLink);
print_r($passage->bibleText);
