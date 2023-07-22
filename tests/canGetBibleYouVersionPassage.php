<?php
echo ("You should see a nicely formatted text below with verse numbers.<hr>");
$bible = new Bible();
$bible->selectBibleByBid(1766);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-6');
writeLogDebug('bibleReferenceInfo', $bibleReferenceInfo);

$passage = new BibleYouVersionPassageController($bibleReferenceInfo, $bible);
$passage->getExternal();
echo ($passage->showPassageText());