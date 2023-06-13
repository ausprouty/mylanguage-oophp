<?php


class DbsPageTranslation
{
  private $translation;


  static function findByHL(string $hl_id)
    {
     $file = __DIR__ .'/../translation/languages/' . $hl_id .'/dbs.json';
     if (file_exists($file)){
        $text = file_get_contents($file);
        $record = json_decode($text);
         return ($record);
     }
     return null;
    }

    static function getBilingualTemplate(array $translation1, array $translation2)
    {
        $file = __DIR__ .'/../templates/dbs.template.html';
        if (!file_exists($file)){
            return null;
        }
        $text = file_get_contents($file);
        foreach ($translation1 as $key => $value){
            $find= '{{' . $key . '}}';
            $template= str_replace ($find, $value, $template);
        }
        foreach ($translation2 as $key => $value){
            $find= '||' . $key . '||';
            $template= str_replace ($find, $value, $template);
        }
        return ($text);
    }

}