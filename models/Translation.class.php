<?php


class Translation
{
  public $translation;

  public function __construct(string $languageCodeHL, string $scope){

    switch ($scope){
        case 'dbs':
            $filename ='dbs.json';
            break;
        default:
            return;
    }
    $file = __DIR__ .'/../translation/languages/' . $languageCodeHL .'/'. $filename;
    if (file_exists($file)){
        $text = file_get_contents($file);
        $translation = json_decode($text);
    }
    else{
        $file = __DIR__ .'/../translation/languages/eng00/'. $filename;
        if (file_exists($file)){
            $text = file_get_contents($file);
            $translation = json_decode($text);
        }
    }
     $this->translation = (array)$translation;
 }
}