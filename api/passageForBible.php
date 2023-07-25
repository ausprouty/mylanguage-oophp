<?php

$bid =intval($_POST['bid']);
$entry =strip_tags($_POST['entry']);
$bible = new Bible();
$bible->selectBibleByBid($bid);
$bibleReferenceInfo = new  BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage($entry);

$passage = new PassageSelectController($bibleReferenceInfo, $bible);

$response = new stdClass();
$response->url = $passage->getPassageUrl();
$response->text = $passage->getPassageText();
ReturnDataController::returnData($response);


