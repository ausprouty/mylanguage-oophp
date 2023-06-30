<?php



class BibleBrainTextJsonController extends BibleBrainPassageController
{
    /*array(1) {
  [0]=>
  object(stdClass)#11 (14) {
    ["book_id"]=>
    string(3) "LUK"
    ["book_name"]=>
    string(27) "Evankeliumi Luukkaan mukaan"
    ["chapter_start"]=>
    int(1)
    ["chapter_end"]=>
    NULL
    ["verse_start"]=>
    int(1)
    ["verse_start_alt"]=>
    string(1) "1"
    ["verse_end"]=>
    NULL
    ["verse_end_alt"]=>
    NULL
    ["timestamp"]=>
    NULL
    ["path"]=>
    string(515) "https://d1gd73roq7kqw6.cloudfront.net/text/FIN38CB/FIN38VN_ET-json/042LUK_001.json?x-amz-transaction=1760104&Expires=1688199679&Signature=OTJ34iUv8rVQOLz-GC5jb0j1P3ulmbF6DB8muGpo9cP7SsttyYMdSKSgVZ7fQXCW0Ioh183zRjeO33iRWBdeX4Y~bz139Bp28aR5mZ7rSDRPWwJhmApQf2rif1jDcniR1OzEGTt9vJryCUNBkt7TT~A2QG96cusEFWi9sLrT3GLEmtrct1UG-6MmbijOfkrCZCmoa0qbg7w9IMKwdCrfsNUFTzf~FTG~TxZ1cxLYVfoAugnP282LjBtBTzYt8v49nHp5rRIb~OEDwQLfB3Rc~XP-ZmvXISe67wUiQeNxtantFgjIIO22f7fj6YyPH4OmyuG~Y631ELA7lSreybWpyg__&Key-Pair-Id=APKAI4ULLVMANLYYPTLQ"
    ["duration"]=>
    NULL
    ["thumbnail"]=>
    NULL
    ["filesize_in_bytes"]=>
    int(70597)
    ["youtube_url"]=>
    NULL
  }
}*/

    function showPassageText(){
        foreach ($this->response as $chapter){
            echo "$chapter->path <br>";
            $json =  new WebsiteConnection($chapter->path);
            writeLogDebug('showPassageJson', $json->response);
        }

    }
    
}