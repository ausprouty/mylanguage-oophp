<?php

$bible = new Bible();
$bible->selectBibleByBid(4092);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-6');

$passage = new BibleBrainTextJsonController($bibleReferenceInfo, $bible);
$passage->getExternal();
print_r ($passage->showPassageText());