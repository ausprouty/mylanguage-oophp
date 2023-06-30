<?php
/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/


class WebsiteConnection
{
    protected $url;
    protected $response;
    
    public function __construct(string $url){
      $this->connect();
    }
    protected function connect() {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
           $decoded = json_decode(curl_exec($curl));
           if (isset($decoded->data)){
                $this->response = $decoded->data;
           }
           else{
                $this->response = $decoded;
           }
        
        } catch (PDOException $e) {
                throw new Exception("Failed to connect to the website: " . $e->getMessage());
        }
    }

}