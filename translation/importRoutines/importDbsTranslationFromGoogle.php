<?php
/* data was prepared on a Google Spread Sheet at https://docs.google.com/spreadsheets/d/1PlTEb4Q4JiHeYPoKw9WsqVq3dqCCnunPRzvBPnvxb20/edit#gid=0
It was then copied and the values pasted into Excell on my local computer.
The values were then copied again into a new file and pasted using the transpose functon
Now they are in sourceFiles/dbs.text

This function will read that file and place them as json objects inside the languages folder

English must be the first column
*/

$file = __DIR__ . '/../sourceFiles/dbs.txt';
if (!file_exists($file)){
    $message = "$file not found in importDbsTranslationFromGoogle";
        echo ($message);
    trigger_error($message , E_USER_ERROR);
    echo ($message);
    return;
}
$text= file_get_contents($file);
$lines = explode("\n", $text);
$english = [];

foreach ($lines as $line){
    $translation = [];
    $items = explode("\t", $line);
    $hl_id= strtolower($items[1]);
    echo ("$hl_id <br>");
    for ($i = 3; $i <31; $i++){
        if (array_key_exists($i, $items)){
            $words = $items[$i];
            if ($words){
                if ($hl_id == 'eng00'){
                    $english[$i] =  $words;
                }
                $key = $english[$i];
                $translation [$key] =  $words;
            }
        }
    }
    $json = json_encode($translation);
    $directory = __DIR__ .'/../languages/' . $hl_id;
    if (!file_exists ($directory)){
        mkdir ($directory);
    }
    $filename =$directory .'/dbs.json';
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, $json);
    fclose($myfile);
}