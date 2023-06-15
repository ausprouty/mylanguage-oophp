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
get('/mylanguage-oophp/test/biblegateway', 'tests/canGetBibleGatewayPassage.php');
get('/mylanguage-oophp/test/dbs/bilingual', 'tests/canMakeStandardBilingualDBS.php');
get('/mylanguage-oophp/bible/$code', 'tests/bestBible.php');
get('/mylanguage-oophp/test/translation', 'tests/canGetTranslation.php');
get('/mylanguage-oophp/language/hl', 'tests/canGetLanguageFromHL.php');
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
