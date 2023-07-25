<?php

$lessons = new dbsStudyController();
$options = $lessons->getOptions();
ReturnDataController::returnData($options);