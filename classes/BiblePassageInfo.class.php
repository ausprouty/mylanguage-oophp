<?php

/* requires entry in form of 'Zephaniah 1:2-3'

 returns an object:
        'entry' => 'Zephaniah 1:2-3'
        'bookId' => 'Zeph',
        'chapterId' => 1,
        'verseStart' => 2,
        'verseEnd' => 3,
         collection_code' => 'OT' ,
 */


class BiblePassageInfo extends BibleBookID

{
    public   $entry;
    private  $chapterStart;
    private  $verseStart;
    private  $chapterEnd;
    private  $verseEnd;


   public function __construct($entry, $language_iso = 'eng'){

        $this->entry = $entry;
        $this->chapterStart = null;
        $this->verseStart = null;
        $this->chapterEnd = null;
        $this->verseEnd = null;;


        $this->checkSpacing($entry);
        $this->findBook();
        $this-> findChapterAndVerses();

    }

    private function checkSpacing($entry){
        // chinese does not use a space before reference
        $entry = trim($entry);
        if (strpos($entry, ' ') === FALSE){
            $first_number= mb_strlen($entry);
            for ($i = 0; $i<=9; $i++){
                $pos = mb_strpos( $entry, $i);
                if ($pos){
                    if($pos < $first_number){
                        $first_number = $pos;
                    }
                }
            }
            $book= mb_substr($this->entry, 0, $first_number);
            $chapter = mb_substr($this->entry,$first_number);
            $entry= $book . ' '. $chapter;
        }
        $this->entry = $entry;
    }
    function findBook(){
        $this->getBookID();
    }


    function findChapterAndVerses(){
        $this->chapterStart = 3;
        $this->verseStart = 16;
        $this->chapterEnd = 3;
        $this->verseEnd = 17;

    }

}