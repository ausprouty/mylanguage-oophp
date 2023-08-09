<?php

$dbs = new DbsBilingualTemplateController($languageCodeHL1, $languageCodeHL2, $lesson);

$dbsReference= new DbsReference();
$dbsReference->setLesson($lesson);

$bibleReferenceInfo= new  BibleReferenceInfo();
$bibleReferenceInfo->setFromEntry($dbsReference->getEntry());
$testament = $bibleReferenceInfo->getTestament();

$bible1 = new Bible();
$bible1->setBestDbsBibleByLanguageCodeHL($languageCodeHL1, $testament);
$dbs->setBibleOne($bible1);

$bible2 = new Bible();
$bible2->setBestDbsBibleByLanguageCodeHL($languageCodeHL2, $testament);
$dbs->setBibleTwo($bible2);

$dbs->setPassage($bibleReferenceInfo);
$dbs->setBilingualTemplate();
//ReturnDataController::returnData($dbs->getTemplate());
$html =  $dbs->getTemplate();
ReturnDataController::returnData($html);
/*$filename = $dbs->getPdfName();

require_once ROOT_VENDOR .'autoload.php';
try{
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'orientation' => 'P'
    ]);
    $mpdf->SetDisplayMode('fullpage');
// Write some HTML code:
    $mpdf->WriteHTML($html);
    // Output a PDF file directly to the browser
    //$mpdf->Output();
    $mpdf->Output($filename, 'D');

} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
    // Process the exception, log, print etc.
    echo $e->getMessage();
}
*/