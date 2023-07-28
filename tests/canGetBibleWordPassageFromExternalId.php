<?php


$bible=new Bible();
$bible->selectBibleByExternalId($externalId);
$bid = $bible->getBid();
echo ("You should see Bible passage for Genesis 1:1-5 for $bid<hr>");
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Genesis 1:1-5');
$passage= new BibleWordPassageController($bibleReferenceInfo, $bible);
echo ($passage->getPassageText());

