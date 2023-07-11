<?php
echo('This should show the French translations <hr>');
$languageCodeHL = 'frn00';
$scope = 'dbs';
$translation = new Translation($languageCodeHL, $scope);
print_r ($translation->translation);