<?php

$data = Bible::getTextBiblesByLanguageCodeIso($languageCodeIso);
ReturnDataController::returnData($data);
die;