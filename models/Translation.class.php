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
    $file =  ROOT_TRANSLATIONS  . $languageCodeHL .'/'. $filename;
    if (file_exists($file)){
        $text = file_get_contents($file);
        $translation = json_decode($text);
    }
    else{
        $file = ROOT_TRANSLATIONS . '/eng00/'. $filename;
        if (file_exists($file)){
            $text = file_get_contents($file);
            $translation = json_decode($text);
        }
        else{
            $translation = [];
            $message = ROOT_TRANSLATIONS . '/eng00/'. $filename . " not found";
            trigger_error( $message, E_USER_ERROR);
           
        }
    }
     $this->translation = (array)$translation;
 }
}