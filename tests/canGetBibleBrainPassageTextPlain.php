<?php

$bible = new Bible();
$bible->selectBibleByBid(1785);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-6');

$passage = new BibleBrainTextPlainController($bibleReferenceInfo, $bible);
$passage->getExternal();
print_r ($passage->showPassageText());