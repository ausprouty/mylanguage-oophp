
<?php

spl_autoload_register('myAutoLoader');

function XmyAutoLoader ($className) {
  //echo ('AutoloadeR is looking for ' . $className  . "<br>");
    $path = 'classes/';
    $extension = '.class.php';
    $fileName = $path . $className . $extension;
    //echo ('Autoloader is looking for file ' . $fileName  . '<br>');
    if (!file_exists($fileName)) {
      return false;
    }

    include_once $path . $className . $extension;
}


function myAutoLoader ($className) {
  //echo ('AutoloadeR is looking for ' . $className  . "<br>");
    $paths = array('models/', 'controllers/');
    foreach ($paths as $path){
      $extension = '.class.php';
      $fileName = $path . $className . $extension;
      //echo ('Autoloader is looking for file ' . $fileName  . '<br>');
      if (file_exists($fileName)) {
        include_once $path . $className . $extension;
        return ;
      }
    }
    return false;
}