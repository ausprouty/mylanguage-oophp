<?php
$languageCodeHL = 'eng00';
$scope = 'dbs';
$translation = new Translation($languageCodeHL, $scope);
print_r ($translation->translation);