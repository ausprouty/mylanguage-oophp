<?php
$languageCodeIso = Language::getCodeIsoFromCodeHL($languageCodeHL);
$data = Bible::getAllBiblesByLanguageCodeIso($languageCodeIso);
ReturnDataController::returnData($data);
die;