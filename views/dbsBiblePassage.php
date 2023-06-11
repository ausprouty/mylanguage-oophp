<?php

$passage = "Matthew 4:3-7";
$book="Matthew";
$language_iso = 'eng';
//$result= new BibleBookID($book);
$info = new  BiblePassageInfo();
$result= $info->setFromPassage($passage);
print_r  ($result);