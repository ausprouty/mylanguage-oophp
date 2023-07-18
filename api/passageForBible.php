<?php

$bid =intval($_POST['bid']);
$entry =strip_tags($_POST['entry']);
$bibleInfo = new Bible();
$bibleInfo->selectBibleByBid($bid);
writeLogDebug('bibleInfo',$bibleInfo);
//
$referenceInfo = (new  BibleReferenceInfo())->setFromPassage($entry);
//
$passage = new PassageSelectController($referenceInfo, $bibleInfo);
writeLogDebug('passage',$passage);
$response = new stdClass();
$response->url = $passage->getPassageUrl();
$response->text = $passage->getPassageText();
writeLogDebug('response', $response);
ReturnDataController::returnData($response);