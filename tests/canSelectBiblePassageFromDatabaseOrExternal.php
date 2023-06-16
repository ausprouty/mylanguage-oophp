<?php
$bible = new Bible();
$bible->selectBibleByBid(1237);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-80');

$passageText= new  PassageSelectController ($bibleReferenceInfo, $bible);
print_r ($passageText->passageText);