<?php

$languages = new dbsLanguageController();
$options = $languages->getOptions();
ReturnDataController::returnData($options);