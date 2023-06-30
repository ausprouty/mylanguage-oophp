<?php

require_once __DIR__.'./router.php';
require_once __DIR__.'/configuration/.env.local.php';
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
require_once __DIR__.'/includes/writeLog.php';

get('/mylanguage-oophp/import/dbs/import', 'imports/canImportDBSReferenceDatabase.php');
// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/mylanguage-oophp', 'tests/index.php');
get('/mylanguage-oophp/bible/test', 'tests/biblePassageControllerTest.php');
get('/mylanguage-oophp/import/bibles/biblebrain', 'imports/addBibleBrainBibles.php');
get('/mylanguage-oophp/import/languages/biblebrain','imports/addBibleBrainLanguages.php');
get('/mylanguage-oophp/import/language/details/biblebrain', 'imports/updateBibleBrainLanguageDetails.php');
get('/mylanguage-oophp/import/passage/update/url', 'imports/canUpdatePassageDatabaseUrl.php');
get('/mylanguage-oophp/import/passage/update/reference', 'imports/canUpdatePassageDatabaseReference.php');
get('/mylanguage-oophp/test/biblegateway', 'tests/canGetBibleGatewayPassage.php');
get('/mylanguage-oophp/test/biblebrain/bible/default', 'tests/canGetBestBibleFromBibleBrain.php');
get('/mylanguage-oophp/test/biblebrain/bible/formats', 'tests/canGetBibleBrainBibleFormatTypes.php');
get('/mylanguage-oophp/test/biblebrain/language', 'tests/canGetBibleBrainLanguageDetails.php');
get('/mylanguage-oophp/test/biblebrain/passage/plain','tests/canGetBibleBrainPassageTextPlain.php');
get('/mylanguage-oophp/test/biblebrain/passage/json', 'tests/canGetBibleBrainPassageTextJson.php');
get('/mylanguage-oophp/test/dbs/bilingual', 'tests/canMakeStandardBilingualDBS.php');
get('/mylanguage-oophp/bible/$code', 'tests/bestBible.php'); // I do not find this helpufl
get('/mylanguage-oophp/test/translation', 'tests/canGetTranslation.php');
get('/mylanguage-oophp/language/hl', 'tests/canGetLanguageFromHL.php');
get('/mylanguage-oophp/languages/country', 'tests/canGetLanguagesForCountryCode.php');
get('/mylanguage-oophp/test/bible/reference/info', 'tests/CanCreateBibleReferenceInfo.php');
get('/mylanguage-oophp/test/passage/select', 'tests/canSelectBiblePassageFromDatabaseOrExternal.php');
get('/mylanguage-oophp/dbs/$lang1/$lang2', 'tests/dbsBilingual.php');
get('/mylanguage-oophp/passage/stored', 'tests/canSeePassageStored.php');
get('/mylanguage-oophp/questions', 'tests/dbsQuestions.php');
get('/mylanguage-oophp/webpage', 'tests/webpage.php');
get('/mylanguage-oophp/import/dbswords', 'translation/importRoutines/importDbsTranslationFromGoogle.php');

// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the tests folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
