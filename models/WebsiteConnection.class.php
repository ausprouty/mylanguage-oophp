<?php



class WebsiteConnection
{
    private $url;
    private $referer;
    public $response;


    public function __construct(string $url, string $referer){
      $this->url = $url;
      $this->referer = $referer;
      $this->connect();
    }
    private function connect() {
        try {
            $agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)';
            $postfields = null;
            $cookie_file_path = null;
            $ch = curl_init();	// Initialize a CURL conversation.
            // The URL to fetch. You can also set this when initializing a conversation with curl_init().
            curl_setopt($ch, CURLOPT_USERAGENT, $agent); // The contents of the "User-Agent: " header to be used in a HTTP request.
            curl_setopt($ch, CURLOPT_POST, 1); //TRUE to do a regular HTTP POST. This POST is the normal application/x-www-form-urlencoded kind, most commonly used by HTML forms.
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postfields); //The full data to post in a HTTP "POST" operation.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // TRUE to follow any "Location: " header that the server sends as part of the HTTP header (note this is recursive, PHP will follow as many "Location: " headers that it is sent, unless CURLOPT_MAXREDIRS is set).
            curl_setopt($ch, CURLOPT_REFERER, $this->referer); //The contents of the "Referer: " header to be used in a HTTP request.
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path); // The name of the file containing the cookie data. The cookie file can be in Netscape format, or just plain HTTP-style headers dumped into a file.
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path); // The name of a file to save all internal cookies to when the connection closes.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //FALSE to stop CURL from verifying the peer's certificate. Alternate certificates to verify against can be specified with the CURLOPT_CAINFO option or a certificate directory can be specified with the CURLOPT_CAPATH option. CURLOPT_SSL_VERIFYHOST may also need to be TRUE or FALSE if CURLOPT_SSL_VERIFYPEER is disabled (it defaults to 2). TRUE by default as of CURL 7.10. Default bundle installed as of CURL 7.10.
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 1 to check the existence of a common name in the SSL peer certificate. 2 to check the existence of a common name and also verify that it matches the hostname provided.
            curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 90); // Wait 90 seconds for download
            curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, 90); // Wait 90 seconds for download
            curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Wait 30 seconds for download
            curl_setopt($ch, CURLOPT_URL, $this->url);
            $this->response = curl_exec($ch);
        } catch (PDOException $e) {
                throw new Exception("Failed to connect to the website: " . $e->getMessage());
        }
    }

}