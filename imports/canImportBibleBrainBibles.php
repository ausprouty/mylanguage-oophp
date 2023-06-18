<?php
$languageCodeIso = 'ahk';
$bibles = new BibleBrainBibleController();
$bibles->getBiblesForLanguageIso($languageCodeIso, 5);
print_r($bibles->response);