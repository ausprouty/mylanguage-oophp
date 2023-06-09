<?php

$translation1 = DbsPageTranslation::findByHL($lang1);
$translation2 = DbsPageTranslation::findByHL($lang2);
$template= DbsPageTranslation::getBilingualTemplate();
foreach ($translation1 as $key => $value){
    $find= '{{' . $key . '}}';
    $template= str_replace ($find, $value, $template);
}
foreach ($translation2 as $key => $value){
    $find= '||' . $key . '||';
    $template= str_replace ($find, $value, $template);
}
echo ($template);
