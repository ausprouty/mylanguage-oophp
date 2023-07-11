<?php

require_once __DIR__.'./router.php';
require_once __DIR__.'/configuration/.env.local.php';
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
require_once __DIR__.'/includes/writeLog.php';


// Index
get('/mylanguage-oophp', 'views/index.php');

// Imports
get(ROOT . 'import/biblebrain/setup', 'imports/clearBibleBrainCheckDate.php');
get(ROOT . 'import/biblebrain/bibles', 'imports/addBibleBrainBibles.php');
get(ROOT . 'import/biblebrain/languages','imports/addBibleBrainLanguages.php');
get(ROOT . 'import/biblebrain/language/details','imports/updateBibleBrainLanguageDetails.php');
get(ROOT . 'import/dbswords', 'translation/importRoutines/importDbsTranslationFromGoogle.php');

// TESTS
get(ROOT . 'test', 'tests/test.php');
//  Web Access
get(ROOT . 'webpage', 'tests/webpage.php');

// Bible Brain
get(ROOT . 'test/biblebrain/language', 'tests/canGetBibleBrainLanguageDetails.php');
get(ROOT . 'test/biblebrain/bible/default', 'tests/canGetBestBibleFromBibleBrain.php');
get(ROOT . 'test/biblebrain/bible/formats', 'tests/canGetBibleBrainBibleFormatTypes.php');
get(ROOT . 'test/biblebrain/passage/json', 'tests/canGetBibleBrainPassageTextJson.php');
get(ROOT . 'test/biblebrain/passage/plain','tests/canGetBibleBrainPassageTextPlain.php');
get(ROOT . 'test/biblebrain/languages/country', 'tests/canGetLanguagesForCountryCode.php');

// Bible Gateway
get(ROOT . 'test/biblegateway', 'tests/canGetBibleGatewayPassage.php');

// DBS
get(ROOT . 'test/dbs/translation', 'tests/canGetDBSTranslation.php');
get(ROOT . 'test/dbs/bilingual', 'tests/canMakeStandardBilingualDBS.php');


//Bibles
get (ROOT. 'test/bibles/best', 'tests/canGetBestBibleByLanguageCodeHL.php');
get (ROOT. 'test/passage/select', 'tests/passageSelectControllerTest.php');

get(ROOT . 'bible/test', 'tests/biblePassageControllerTest.php');





get(ROOT . 'language/hl', 'tests/canGetLanguageFromHL.php');

get(ROOT . 'test/bible/reference/info', 'tests/CanCreateBibleReferenceInfo.php');
get(ROOT . 'test/passage/select', 'tests/canSelectBiblePassageFromDatabaseOrExternal.php');

get(ROOT . 'passage/stored', 'tests/canSeePassageStored.php');




// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the tests folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
