<?php

require_once __DIR__.'./router.php';
require_once __DIR__.'/configuration/.env.local.php';
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
require_once __DIR__.'/includes/writeLog.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");
header("Content-type: application/json");
writeLogDebug('routes', "I made it");
if (isset($_POST)){
    writeLogDebug('post', json_decode($_POST));
}



//API
get(ROOT . 'api/bibles/$languageCodeIso', 'api/biblesForLanguage.php');
get(ROOT . 'api/bibles/text/$languageCodeIso', 'api/biblesForLanguageTextOnly.php');
get(ROOT . 'api/secure/bibles/weight/change', 'api/secure/bibleWeightChange.php');


get(ROOT . 'api/dbs/$lesson/$lang1/$lang2/', 'api/dbsBilingual.php');
get(ROOT . 'api/dbs2/$lesson/$lang1/$lang2/', 'api/dbsBilingual2.php');
get(ROOT . 'api/dbs/$lesson/$lang1', 'api/dbs.php');

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
get(ROOT . 'test/biblebrain/passage/formatted','tests/canGetBibleBrainPassageTextFormatted.php');
get(ROOT . 'test/biblebrain/passage/usx','tests/canGetBibleBrainPassageTextUsx.php');
get(ROOT . 'test/biblebrain/languages/country', 'tests/canGetLanguagesForCountryCode.php');

// Bible Gateway
get(ROOT . 'test/biblegateway', 'tests/canGetBibleGatewayPassage.php');

// DBS
get(ROOT . 'test/dbs/translation', 'tests/canGetDBSTranslation.php');
get(ROOT . 'test/dbs/bilingual', 'tests/canMakeStandardBilingualDBS.php');
get(ROOT . 'test/dbs/pdf', 'tests/canPrintPdf.php');


//Bibles
get (ROOT. 'test/bibles/best', 'tests/canGetBestBibleByLanguageCodeHL.php');
get (ROOT. 'test/passage/select', 'tests/passageSelectControllerTest.php');
get(ROOT . 'test/bible', 'tests/biblePassageControllerTest.php');

//Database
get(ROOT . 'test/language/hl', 'tests/canGetLanguageFromHL.php');





get(ROOT . 'test/bible/reference/info', 'tests/CanCreateBibleReferenceInfo.php');
get(ROOT . 'test/passage/select', 'tests/canSelectBiblePassageFromDatabaseOrExternal.php');

get(ROOT . 'test/passage/stored', 'tests/canSeePassageStored.php');




// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the tests folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
