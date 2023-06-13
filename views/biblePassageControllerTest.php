<?php

$code = 'eng00';
$entry = 'John 3:16-18';
$bible = new Bible();
$bible->setBestBibleByLanguageCodeHL($code);
print_r ($bible);
$reference = 'John 3:16-40';
$info = new  BibleReferenceInfo();
$info->setFromPassage($reference);
print_r ($info);

$passage = new BiblePassageExternal();
