<?php
echo ("You should see a nicely formatted text below with verse numbers.<hr>");
$bible = new Bible();
$bible->selectBibleByBid(6349);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-6');

$passage = new BibleBrainTextPlainController($bibleReferenceInfo, $bible);
$passage->getExternal();
echo ($passage->getPassageText());