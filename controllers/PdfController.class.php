<?php
// Require composer autoload


class PdfController {

    private $mpdf;

    public function __construct(){
        require_once ROOT_VENDOR .'autoload.php';
        $this->mpdf = new \Mpdf\Mpdf();
    }

    public function writeToBrowser($text){
        $this->mpdf->WriteHTML($text);
        $this->mpdf->Output();
    }
          
}

    
