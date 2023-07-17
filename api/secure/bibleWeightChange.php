<?php
    /*
      input
        bid:string
        changed: sring ('true'\ or 'false')
    */
 $authorized = Authorize::authorized($_POST);
  if (!$authorized){
    ReturnDataController::returnNotAuthorized();
   die;
  }
  if ($_POST['checked'] =='true'){
    $weight = 9;
  }
  else{
    $weight = 0;
  }
  $bid =intval($_POST['bid']);
  $update = Bible::updateWeight($bid, $weight);
  ReturnDataController::returnData($update);
  die;
