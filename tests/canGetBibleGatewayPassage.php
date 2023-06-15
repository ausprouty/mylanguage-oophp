<?php

$bible=new Bible();
$bible->selectBibleByBid(1237);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-80');

$passage= new BibleGatewayController($bibleReferenceInfo, $bible);
$passage->getExternal();
print_r ($passage->bibleText);