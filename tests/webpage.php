<?php

$url = 'https://hereslife.com';
$referer = 'https://hereslife.com';
$website = new WebsiteConnection($url, $referer);
echo ($website->response);