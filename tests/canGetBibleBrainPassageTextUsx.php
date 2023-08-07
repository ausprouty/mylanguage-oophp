<?php
echo ("You may be able to modify this so that you can download an entire book (in nice format) and then parse it.  
Look for the URL ion the BibleBrainJson Controller <hr>");
$bible = new Bible();
$bible->selectBibleByBid(6282);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-6');
$passage = new BibleBrainTextJsonController($bibleReferenceInfo, $bible);
$passage->getExternal();
echo ($passage->getPassageText());