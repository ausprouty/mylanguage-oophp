<?php

$lessons = new dbsStudyController();
$data = $lessons->formatWithEnglishTitle();
ReturnDataController::returnData($data);