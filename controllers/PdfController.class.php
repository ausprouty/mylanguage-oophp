<?php
// Require composer autoload
// see https://mpdf.github.io/ 


class PdfController {

    private $mpdf;

    public function __construct(){
        require_once ROOT_VENDOR .'autoload.php';
        $this->mpdf = new \Mpdf\Mpdf();
    }

    public function writeToBrowser($html, $stylesheet){
        $stylesheet = file_get_contents(ROOT_STYLES . $stylesheet);
        $this->mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $this->mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
        $this->mpdf->Output();
    }
          
}

    
