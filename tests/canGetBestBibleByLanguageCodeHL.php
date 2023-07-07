<?php
$code = 'eng00';
echo ("For eng00 you should see Young's Literal Translation<hr>");
$bible = new Bible();
$bible->getBestBibleByLanguageCodeHL($code);
print_r($bible->getVolumeName());