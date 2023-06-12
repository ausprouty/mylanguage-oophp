<?php
echo ("$code<br><br>");
$bible = new Bible();
$bible->setBestBibleByLanguageCodeHL($code);
//print_r($bible);