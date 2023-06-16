<?php
$bible = new Bible();
$bible->selectBibleByBid(1237);
$bibleReferenceInfo = new BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage('Luke 1:1-80');

$bibleText= new  PassageSelectController ($bibleReferenceInfo, $bible);
print_r ($bibleText->bibleText);