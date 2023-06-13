<?php

require_once __DIR__.'./router.php';
require_once __DIR__.'/configuration/.env.local.php';
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
require_once __DIR__.'/includes/writeLog.php';


// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/mylanguage-oophp', 'tests/index.php');
get('/mylanguage-oophp/bible/test', 'tests/biblePassageControllerTest.php');
get('/mylanguage-oophp/bible/$code', 'tests/bestBible.php');
get('/mylanguage-oophp/test1', 'tests/test1.php');
get('/mylanguage-oophp/language', 'tests/languageFind.php');
get('/mylanguage-oophp/reference', 'tests/bibleReferenceInfo.php');
get('/mylanguage-oophp/dbs/$lang1/$lang2', 'tests/dbsBilingual.php');
get('/mylanguage-oophp/questions', 'tests/dbsQuestions.php');
get('/mylanguage-oophp/webpage', 'tests/webpage.php');
get('/mylanguage-oophp/import/dbswords', 'translation/importRoutines/importDbsTranslationFromGoogle.php');

// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the tests folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
