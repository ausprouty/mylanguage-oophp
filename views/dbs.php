<?php
$questions = new DbsQuestion();
$output =  $questions->findByHL('eng00');
print_r($output);