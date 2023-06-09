<?php

require_once __DIR__.'./router.php';
require_once __DIR__.'/configuration/.env.local.php';
require_once  __DIR__.'/configuration/class-autoload.inc.php';
##################################################
// see https://opis.io/orm/1.x/quick-start.html

// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/mylanguage-oophp', 'views/index.php');

get('/mylanguage-oophp/test1', 'views/test1.php');
get('/mylanguage-oophp/dbs', 'views/dbs.php');
get('/mylanguage-oophp/reference', 'views/dbsReference.php');

get('/mylanguage-oophp/import/dbswords', 'translation/importRoutines/importDbsTranslationFromGoogle.php');

// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
