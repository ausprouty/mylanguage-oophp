<?php

$language_iso = 'eng';
$info = new  BibleReferenceInfo();
$result= $info->setFromPassage($passage);
print_r  ($result);