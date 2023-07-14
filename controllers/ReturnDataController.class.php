<?php

class ReturnDataController {

    static function returnData($data){
       // header("Access-Control-Allow-Origin: " . ACCEPTABLE_IP);
       // header("Access-Control-Allow-Methods: POST, GET");
       // header("Content-type: application/json");
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

    }
    static function returnOK(){
        $data = 'success';
        header("Access-Control-Allow-Origin: " . ACCEPTABLE_IP);
        header("Access-Control-Allow-Methods: POST, GET");
        header("Content-type: application/json");
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

      

    }
}