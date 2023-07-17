<?php

$bid =intval($_POST['bid']);
$entry =strip_tags($_POST['entry']);
$bibleInfo = new Bible();
$bibleInfo->selectBibleByBid($bid);
writeLogDebug('bibleInfo',$bibleInfo);
$referenceInfo = new  BibleReferenceInfo();
$referenceInfo->setFromPassage($entry);
writeLogDebug('referenceInfo',$referenceInfo);
$passage = new PassageSelectController($referenceInfo, $bibleInfo);
writeLogDebug('passage',$passage->getBibleText);
$response = new stdObj();
$response->url = $passage->getPassageUrl();
$response->text = $passage->getPassageText();
writeLogDebug('response', $response);
ReturnDataController::returnData($response);