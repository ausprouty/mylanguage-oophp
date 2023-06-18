<?php
$countryCode = 'AU';
$languages = new BibleBrainLanguageController();
$languages->getLanguagesFromCountryCode($countryCode);
print_r($languages->response);
writeLogDebug('canGetLanguagesForCountryCode', $languages->response);