<?php

$passage = 'John 3:16-40';
$info = new  BibleReferenceInfo();
$result= $info->setFromPassage($passage);
print_r  ($result);