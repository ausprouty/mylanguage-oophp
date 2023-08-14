<?php

class ReturnDataController {

    static function returnData($data){
       header("Access-Control-Allow-Origin: " . ACCEPTABLE_IP);
       header("Access-Control-Allow-Methods: POST, GET");
       header("Content-type: application/json");
       echo json_encode($data, JSON_UNESCAPED_UNICODE);
       writeLogDebug('return Data',  json_encode($data, JSON_UNESCAPED_UNICODE));

    }
    static function returnNotAuthorized(){
        $data = 'not Authorized';
        header("Access-Control-Allow-Origin: " . ACCEPTABLE_IP);
        header("Access-Control-Allow-Methods: POST, GET");
        header("Content-type: application/json");
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}