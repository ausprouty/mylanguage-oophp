<?php

$languageCodeHL = strip_tags($languageCodeHL);
$language = new Language();
$data = $language->findOneByCode('HL', $languageCodeHL);
ReturnDataController::returnData($data);


