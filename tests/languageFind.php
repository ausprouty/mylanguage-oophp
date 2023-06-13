<?php
$language = new Language();
$result=$language->findOneByCode('HL', 'eng00');
print_r($result);