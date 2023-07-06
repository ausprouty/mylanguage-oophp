<?php
/*  see https://documenter.getpostman.com/view/12519377/Tz5p6dp7
*/


class CloudFrontConnection
{
    protected $url;
    public $response;
    
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
            $this->response = curl_exec($curl);
        
        } catch (PDOException $e) {
                throw new Exception("Failed to connect to the website: " . $e->getMessage());
        }
    }

}