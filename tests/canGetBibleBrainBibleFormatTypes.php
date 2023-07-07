<?php

echo"you should see an object below with all the format types<hr>";
$bible=new BibleBrainBibleController();
$bible->getFormatTypes();
$bible->response;
print_r( $bible->response);