<?php
echo ('This should show the ethnic name of French<hr>');
$language = new Language();
$language->findOneByCode('HL', 'frn00');
print_r($language->getEthnicName());