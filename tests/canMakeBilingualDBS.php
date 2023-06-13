<?php
$lang1 ='eng00';
$lang2= 'frn00';
$passage= 'Romans 3:4-7';


$translation1 = DbsPageTranslation::findByHL($lang1);
$translation2 = DbsPageTranslation::findByHL($lang2);
$template= DbsPageTranslation::getBilingualTemplate($translation1, $translation2);
echo ($template);
