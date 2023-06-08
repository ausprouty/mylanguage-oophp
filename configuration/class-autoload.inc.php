
<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader ($className) {
  //echo ('AutoloadeR is looking for ' . $className  . "<br>");
    $path = 'classes/';
    $extension = '.class.php';
    $fileName = $path . $className . $extension;
   // echo ('Autoloader is looking for file ' . $fileName  . '<br>');
    if (!file_exists($fileName)) {
      return false;
    }

    include_once $path . $className . $extension;
}
