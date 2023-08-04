<?php

$lessons = new DbsStudyController();
$data = $lessons->formatWithEnglishTitle();
ReturnDataController::returnData($data);