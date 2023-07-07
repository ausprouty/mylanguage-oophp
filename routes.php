<?php

require_once __DIR__.'./router.php';
require_once __DIR__.'/configuration/.env.local.php';
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
require_once __DIR__.'/includes/writeLog.php';


// Index
get('/mylanguage-oophp', 'views/index.php');

//  Web Access
get(ROOT . 'webpage', 'tests/webpage.php');

// Bible Brain
get(ROOT . 'test/biblebrain/language', 'tests/canGetBibleBrainLanguageDetails.php');

// Bible Gateway
get(ROOT . 'test/biblegateway', 'tests/canGetBibleGatewayPassage.php');

get(ROOT . 'import/dbs/import', 'imports/canImportDBSReferenceDatabase.php');
get(ROOT . 'bible/test', 'tests/biblePassageControllerTest.php');
get(ROOT . 'import/bibles/biblebrain', 'imports/addBibleBrainBibles.php');
get(ROOT . 'import/languages/biblebrain','imports/addBibleBrainLanguages.php');
get(ROOT . 'import/language/details/biblebrain', 'imports/updateBibleBrainLanguageDetails.php');
get(ROOT . 'import/passage/update/url', 'imports/canUpdatePassageDatabaseUrl.php');
get(ROOT . 'import/passage/update/reference', 'imports/canUpdatePassageDatabaseReference.php');

get(ROOT . 'test/biblebrain/bible/default', 'tests/canGetBestBibleFromBibleBrain.php');
get(ROOT . 'test/biblebrain/bible/formats', 'tests/canGetBibleBrainBibleFormatTypes.php');

get(ROOT . 'test/biblebrain/passage/plain','tests/canGetBibleBrainPassageTextPlain.php');
get(ROOT . 'test/biblebrain/passage/json', 'tests/canGetBibleBrainPassageTextJson.php');
get(ROOT . 'test/dbs/bilingual', 'tests/canMakeStandardBilingualDBS.php');
get(ROOT . 'bible/$code', 'tests/bestBible.php'); // I do not find this helpufl
get(ROOT . 'test/translation', 'tests/canGetTranslation.php');
get(ROOT . 'language/hl', 'tests/canGetLanguageFromHL.php');
get(ROOT . 'languages/country', 'tests/canGetLanguagesForCountryCode.php');
get(ROOT . 'test/bible/reference/info', 'tests/CanCreateBibleReferenceInfo.php');
get(ROOT . 'test/passage/select', 'tests/canSelectBiblePassageFromDatabaseOrExternal.php');
get(ROOT . 'dbs/$lang1/$lang2', 'tests/dbsBilingual.php');
get(ROOT . 'passage/stored', 'tests/canSeePassageStored.php');
get(ROOT . 'questions', 'tests/dbsQuestions.php');

get(ROOT . 'import/dbswords', 'translation/importRoutines/importDbsTranslationFromGoogle.php');

// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the tests folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
