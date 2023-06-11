<?php



class BibleBookID

{
    private  $language_iso;
    private  $bookName;
    private  $bookID;
    private  $testament;



    public function __construct(){
        $this->language_iso = null;
        $this->bookName = null;
        $this->testament = null;
        $this->bookID = null;
    }



}