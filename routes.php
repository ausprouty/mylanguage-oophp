<?php
$dir = __DIR__ ;
require_once __DIR__ .'/router.php';
if ( $dir == '/home/mylanguagenet/api.mylanguage.net.au'){
    require_once $dir .'/configuration/.env.remote.php';
}
else{
    require_once $dir .'/configuration/.env.local.php';
}
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
require_once __DIR__.'/includes/writeLog.php';

//API
get(WEB_ROOT . 'api/bibles/$languageCodeHL', 'api/biblesForLanguage.php');
get(WEB_ROOT . 'api/bibles/dbs/next/$languageCodeHL','api/bibleForDbsNext.php');
get(WEB_ROOT . 'api/bibles/text/$languageCodeHL', 'api/biblesForLanguageTextOnly.php');
get(WEB_ROOT . 'api/dbs/languages', 'api/dbsLanguageOptions.php');
get(WEB_ROOT . 'api/dbs/studies', 'api/dbsStudyOptions.php');
get(WEB_ROOT . 'api/language/$languageCodeHL', 'api/languageDetails.php');
post(WEB_ROOT . 'api/passage/text', 'api/passageForBible.php');

post(WEB_ROOT . 'api/secure/bibles/weight/change', 'api/secure/bibleWeightChange.php');


get(WEB_ROOT . 'api/dbs/view/$lesson/$languageCodeHL1/$languageCodeHL2', 'api/dbsBilingualView.php');
get(WEB_ROOT . 'api/dbs/drupal/view/$lesson/$languageCodeHL1/$languageCodeHL2', 'api/dbsBilingualViewDrupal.php');
get(WEB_ROOT . 'api/dbs/pdf/$lesson/$languageCodeHL1/$languageCodeHL2', 'api/dbsBilingualPdf.php');
get(WEB_ROOT . 'api/dbs/$lesson/$languageCodeHL', 'api/dbs.php');

// Index
get('/local', 'views/indexLocal.php');
get('/remote', 'views/indexRemote.php');
get('/', 'views/index.php');

// Imports

get(WEB_ROOT . 'import/bible/languages', 'imports/addHLCodeToBible.php');
get(WEB_ROOT . 'import/bibleBookNames/languages', 'imports/addHLCodeToBibleBookNames.php');
get(WEB_ROOT . 'import/biblebrain/setup', 'imports/clearBibleBrainCheckDate.php');
get(WEB_ROOT . 'import/biblebrain/bibles', 'imports/addBibleBrainBibles.php');
get(WEB_ROOT . 'import/biblebrain/languages','imports/addBibleBrainLanguages.php');
get(WEB_ROOT . 'import/biblebrain/language/details','imports/updateBibleBrainLanguageDetails.php');
get(WEB_ROOT . 'import/biblegateway/bibles', 'imports/addBibleGatewayBibles.php');
get(WEB_ROOT . 'import/dbs/words', 'translation/importRoutines/importDbsTranslationFromGoogle.php');
get(WEB_ROOT . 'import/dbs/database', 'imports/UpdateDbsLanguages.php');
get(WEB_ROOT . 'import/bible/externalId', 'imports/updateBibleExternalId.php');

// TESTS
get(WEB_ROOT . 'test', 'tests/test.php');
//  Web Access
get(WEB_ROOT . 'webpage', 'tests/webpage.php');

// word
get(WEB_ROOT . 'test/word/passage/$externalId','tests/canGetBibleWordPassageFromExternalId.php');

// Bible Brain
get(WEB_ROOT . 'test/biblebrain/language', 'tests/canGetBibleBrainLanguageDetails.php');
get(WEB_ROOT . 'test/biblebrain/bible/default', 'tests/canGetBestBibleFromBibleBrain.php');
get(WEB_ROOT . 'test/biblebrain/bible/formats', 'tests/canGetBibleBrainBibleFormatTypes.php');
get(WEB_ROOT . 'test/biblebrain/passage/json', 'tests/canGetBibleBrainPassageTextJson.php');

get(WEB_ROOT . 'test/biblebrain/passage/formatted','tests/canGetBibleBrainPassageTextFormatted.php');
get(WEB_ROOT . 'test/biblebrain/passage/usx','tests/canGetBibleBrainPassageTextUsx.php');
get(WEB_ROOT . 'test/biblebrain/languages/country', 'tests/canGetLanguagesForCountryCode.php');

// Bible Gateway
get(WEB_ROOT . 'test/biblegateway', 'tests/canGetBibleGatewayPassage.php');

//YouVersion
get(WEB_ROOT . 'test/youversion/link', 'tests/canGetBibleYouVersionLink.php');

// DBS
get(WEB_ROOT . 'test/dbs/translation', 'tests/canGetDBSTranslation.php');
get(WEB_ROOT . 'test/dbs/bilingual', 'tests/canMakeStandardBilingualDBS.php');
get(WEB_ROOT . 'test/dbs/pdf', 'tests/canPrintDbsPdf.php');


//Bibles
get (WEB_ROOT. 'test/bibles/best', 'tests/canGetBestBibleByLanguageCodeHL.php');
get (WEB_ROOT. 'test/passage/select', 'tests/passageSelectControllerTest.php');
get(WEB_ROOT . 'test/bible', 'tests/biblePassageControllerTest.php');

//Database
get(WEB_ROOT . 'test/language/hl', 'tests/canGetLanguageFromHL.php');





get(WEB_ROOT . 'test/bible/reference/info', 'tests/CanCreateBibleReferenceInfo.php');
get(WEB_ROOT . 'test/passage/select', 'tests/canSelectBiblePassageFromDatabaseOrExternal.php');

get(WEB_ROOT . 'test/passage/stored', 'tests/canSeePassageStored.php');




// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the tests folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
