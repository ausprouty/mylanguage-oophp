<?php
$languageCodeIso = Language::getCodeIsoFromCodeHL($languageCodeHL);
$data = Bible::getTextBiblesByLanguageCodeIso($languageCodeIso );
ReturnDataController::returnData($data);
die;