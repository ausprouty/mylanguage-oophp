<?php
echo ("You should see a nicely formatted text below with verse numbers.<hr>");
$bible = new Bible();
$bible->selectBibleByBid(1766);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromEntry('Luke 1:1-6');

$passage = new BibleYouVersionPassageController($bibleReferenceInfo, $bible);
$passage->getLink();
echo ($passage->getLink());