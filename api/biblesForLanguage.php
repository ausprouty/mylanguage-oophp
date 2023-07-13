<?php

$data = Bible::getAllBiblesByLanguageCodeIso($languageCodeIso);
ReturnDataController::returnData($data);
die;