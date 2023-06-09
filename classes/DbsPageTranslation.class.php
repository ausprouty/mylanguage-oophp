<?php


class DbsPageTranslation
{
  private $translation;

  static function findByHL($hl_id)
    {
     $file = __DIR__ .'/../translation/languages/' . $hl_id .'/dbs.json';
     if (file_exists($file)){
        $text = file_get_contents($file);
        $record = json_decode($text);
         return ($record);
     }
     return null;
    }
    static function getBilingualTemplate()
    {
     $file = __DIR__ .'/../templates/dbs.template.html';
        if (file_exists($file)){
            $text = file_get_contents($file);
            return ($text);
        }
        return null;
    }

}