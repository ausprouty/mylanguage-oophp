<?php
$languageCodeIso = 'en';
$bible = new BibleBrainBibleController();
$bible->getDefaultBible($languageCodeIso);
print_r($bible->response);