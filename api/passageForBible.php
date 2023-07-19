<?php

$bid =intval($_POST['bid']);
$entry =strip_tags($_POST['entry']);
$bible = new Bible();
$bible->selectBibleByBid($bid);
writeLogDebug('PassageForBible-7- bibleInfo',$bible);
//
$bibleReferenceInfo = new  BibleReferenceInfo();
$bibleReferenceInfo->setFromPassage($entry);

//
$passage = new PassageSelectController($bibleReferenceInfo, $bible);
writeLogDebug('PassageForBible-14 - passage',$passage);
$response = new stdClass();
$response->url = $passage->getPassageUrl();
$response->text = $passage->getPassageText();
writeLogDebug('PassageForBible-16 - response', $response);
ReturnDataController::returnData($response);

