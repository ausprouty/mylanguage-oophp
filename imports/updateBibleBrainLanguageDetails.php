<?php
$max = 1;
echo ("You should see the languageCodeIso below that you are updating Language Details for<br>");
echo ("This routine is driven by the values of checkedBBBibles in hl_languages");
echo ("You need to run Import Languages from BibleBrain before running this routine. <hr>");
for ($i=0; $i<$max; $i++){
    $languageDetails = new BibleBrainLanguageController();
    $languageCodeIso =  $languageDetails->getNextLanguageforLanguageDetails();
    if ($languageCodeIso == NULL){
        echo ('I am finished. Please run Import Languages from BibleBrain again if you want to restart');
        return;
    }
    if (!$languageDetails->BibleBrainLanguageRecordExistsForIso($languageCodeIso)){
        // echo ("$languageCodeIso does not have Bible Brain Info<br>");
         $languageDetails->getlanguageDetails($languageCodeIso);
         $languageDetails->updateBibleBrainLanguageDetails();
         $languageDetails->setLanguageDetailsComplete($languageCodeIso);
         echo ("checking $languageCodeIso <br>");
         $count++;
     }
    if ($count >  $maxImport){
         break;
     }
}
