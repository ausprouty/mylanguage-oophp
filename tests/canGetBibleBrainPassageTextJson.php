<?php

$bible = new Bible();
$bible->selectBibleByBid(4092);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-6');
$passage = new BibleBrainTextJsonController($bibleReferenceInfo, $bible);
$passage->getExternal();
echo ("You should see a json object below.  I have no idea how to use it. <hr>");
print_r ($passage->getJson());