<?php
require_once ROOT_VENDOR .'autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML('Hello World');

// Output a PDF file directly to the browser
$mpdf->Output();