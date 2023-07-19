<?php
$data = Bible::getAllBiblesByLanguageCodeHL($languageCodeHL);
ReturnDataController::returnData($data);
die;