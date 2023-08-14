<?php
/* First we will see if we have the pdf of the study you want.
   If not, we will create it
   Then store it
   Then send you the address of the file you can download
*/
$filename =  $languageCodeHL1 .'-'. $languageCodeHL2 .'-'. $lesson .'.pdf';
writeLogDebug('filename', $filename);
if (!file_exists(ROOT_DBS_PDF . $filename)){
    $html = createDbsForPdf($languageCodeHL1, $languageCodeHL2, $lesson);
    writeLogDebug('html', $html);
    require_once ROOT_VENDOR .'autoload.php';
    try{
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'orientation' => 'P'
        ]);
        writeLogDebug('dbs-18', $html);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        writeLogDebug('stored', ROOT_DBS_PDF . $filename);
        $mpdf->Output(ROOT_DBS_PDF . $filename, 'F');
        writeLogDebug('dbs-23', $html);
    } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
        writeLogDebug('dbsBilingualError', $e);

    }
    
}
$response['pdf'] = WEBADDRESS_DBS_PDF . $filename;
$response['name'] = DbsLanguageController::dbsPublicFilename( $languageCodeHL1, $languageCodeHL2, $lesson );
ReturnDataController::returnData($response);


function createDbsForPdf ($languageCodeHL1, $languageCodeHL2, $lesson){
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
    return $html;
}