<?php
$references = new DbsReference();
$output =  $references->findByHL('eng00');
print_r($output);