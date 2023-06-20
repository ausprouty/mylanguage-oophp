<?php

$bible=new BibleBrainBibleController();
$bible->getFormatTypes();
$bible->response;
writeLogDebug('BibleBrainBibleFormatTypes', $bible->response);