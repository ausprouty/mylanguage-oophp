<?php
$data = Bible::getTextBiblesByLanguageCodeHL($languageCodeHL );
ReturnDataController::returnData($data);
die;