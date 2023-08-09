<?php

$languages = new DbsLanguageController();
$options = $languages->getOptions();
ReturnDataController::returnData($options);