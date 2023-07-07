<?php
$bible=new Bible();
$bible->selectBibleByBid(1237);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-80');

$passage= new BibleGatewayPassageController($bibleReferenceInfo, $bible);
$passage->getExternal();
echo ('You should see Bible passage for Luke 1:1-80<hr>');
print_r ($passage->getPassageText());
