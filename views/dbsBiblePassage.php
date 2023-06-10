<?php

$passage = "Matthew 4:3-7";
$book="Matthew";
$language_iso = 'eng';
//$result= new BibleBookID($book);
$result = new  BiblePassageInfo($passage);
print_r  ($result);