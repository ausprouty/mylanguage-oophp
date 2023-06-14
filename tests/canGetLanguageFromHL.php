<?php

$language = new Language();
$language->findOneByCode('HL', 'eng00');
print_r($language);