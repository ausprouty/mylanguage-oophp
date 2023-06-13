<?php

$translation1 = DbsPageTranslation::findByHL($lang1);
$translation2 = DbsPageTranslation::findByHL($lang2);
$template= DbsPageTranslation::getBilingualTemplate($translation1, $translation2);
echo ($template);
