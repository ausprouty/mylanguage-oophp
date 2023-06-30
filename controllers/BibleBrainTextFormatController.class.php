<?php



class BibleBrainTextFormatController extends BibleBrainPassageController
{
 
    public function showPassageText()
    {
        return $this->passageText;
    }
    
}