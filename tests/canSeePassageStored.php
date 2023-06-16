<?php

$bible=new Bible();
$bible->selectBibleByBid(1026);

$passage= new BibleReferenceInfo();
$passage->setFromPassage('Luke 1:1-80');
$text = new PassageSelectController ($passage, $bible);
print_r ($text->passageText);
//1026-Luke-1-1-80