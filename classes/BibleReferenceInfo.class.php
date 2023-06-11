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

    private $dbConnection;
    public   $entry;
    private  $language_iso;
    private  $bookName;
    private  $bookID;
    private  $testament;
    private  $chapterStart;
    private  $verseStart;
    private  $chapterEnd;
    private  $verseEnd;


   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
    }

    public function setFromPassage($entry, $language_iso = 'eng'){
        $this->checkSpacing($entry);
        $this->findBook();
        $this->findBookID();
        $this->getTestament();
        $this->findChapterAndVerses();
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
    protected function findBookID(){
        $query = 'SELECT book_id FROM bible_book_names
            WHERE (language_iso = :language_iso OR language_iso = :english)
            AND name = :book_lookup LIMIT 1';
        $params = array(':language_iso'=>$this->language_iso, ':english' => 'eng', ':book_lookup'=>$this->bookName );
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_COLUMN);
            $this->bookID = $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    protected function getTestament(){
        $query = 'SELECT testament FROM bible_books
            WHERE book_id = :book_id  LIMIT 1';
        $params = array(':book_id'=>$this->bookID );
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetch(PDO::FETCH_COLUMN);
            $this->testament = $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }


    function findChapterAndVerses(){
        $pass = str_replace($this->bookName, '', $this->entry);
        $pass = str_replace(' ' , '', $pass);
        $pass = str_replace('፡' , ':', $pass); // from Amharic
        $i = strpos($pass, ':');
        if ($i == FALSE){
            // this is the whole chapter
            $this->chapterStart = trim($pass);
            $this->verseStart = 1;
            $this->verseEnd = 999;
        }
        else{
            $this->chapterStart = substr($pass, 0, $i);
            $verses = substr($pass, $i+1);
            $i = strpos ($verses, '-');
            if ($i !== FALSE){
                $this->verseStart = substr($verses, 0, $i);
                $this->verseEnd = substr($verses, $i+1);
            }
            else{
                $this->verseStart = $verses;
                $this->verseEnd = $verses;
            }
        }
    }


}