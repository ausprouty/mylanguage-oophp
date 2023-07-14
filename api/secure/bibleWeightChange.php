<?php
    $data = 'success';

   
    writeLogDebug('post', $_POST);
    writeLogDebug('get', $_GET);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
die;
