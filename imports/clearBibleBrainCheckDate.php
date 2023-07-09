<?php

echo('You have just cleared CheckedBBBibles so you can run the next two routines');

$languageDetails = new  BibleBrainLanguageController();
$languageDetails->clearCheckedBBBibles();