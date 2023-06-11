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


class BibleReferenceInfo

{
    public   $entry;
    private  $chapterStart;
    private  $verseStart;
    private  $chapterEnd;
    private  $verseEnd;


   public function __construct(){

        $this->entry = null;
        $this->chapterStart = null;
        $this->verseStart = null;
        $this->chapterEnd = null;
        $this->verseEnd = null;;
    }

    public function setFromPassage($entry, $language_iso = 'eng'){
        $this->checkSpacing($entry);
        $this->findBook();
        $this->findBookID();
        $this->getTestament();
        return $this;// this should give us   $this->entry;

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
        $parts = explode(' ', $this->entry);
        $book = $parts[0];
        if ($book == 1 || $book == 2 || $book == 3){
            $book .= ' '. $parts[1];
        }
        if ($book == 'Psalm'){
            $book = 'Psalms';
        }
        $this->bookName= $book;

    }


    function findChapterAndVerses(){
        $this->chapterStart = 3;
        $this->verseStart = 16;
        $this->chapterEnd = 3;
        $this->verseEnd = 17;

    }

}