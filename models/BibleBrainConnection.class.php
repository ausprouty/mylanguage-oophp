<?php



class BibleBrainConnection
{
    private $url;
    public $response;
    
    public function __construct(string $url){
      $this->url = $url . '&v=4&key=' .  BIBLE_BRAIN_KEY;
      $this->connect();
    }
    private function connect() {
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
           $decode = json_decode(curl_exec($curl));
           $this->response = $decode->data;
        } catch (PDOException $e) {
                throw new Exception("Failed to connect to the website: " . $e->getMessage());
        }
    }

}