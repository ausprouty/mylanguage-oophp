<?php

$url = 'https://hereslife.com';

$website = new WebsiteConnection($url);
echo "You should see the hereslife website below<br><hr>";
echo ($website->response);