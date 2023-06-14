<?php


class Translation
{
  public $translation;

  public function __construct(string $hl_id, string $scope){
    $this->translation = null;
    switch ($scope){
        case 'dbs':
            $filename ='dbs.json';
            break;
        default:
            return;
    }
    $file = __DIR__ .'/../translation/languages/' . $hl_id .'/'. $filename;
    if (file_exists($file)){
        $text = file_get_contents($file);
        $this->translation = json_decode($text);
    }
    else{
        $file = __DIR__ .'/../translation/languages/eng00/'. $filename;
        if (file_exists($file)){
            $text = file_get_contents($file);
            $this->translation = json_decode($text);
        }
    }
  }
}