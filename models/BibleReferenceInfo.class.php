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

    private  $dbConnection;
    public   $entry;
    private  $language_iso;
    public   $bookName;
    public   $bookID;
    public   $testament;
    public   $chapterStart;
    public   $verseStart;
    public   $chapterEnd;
    public   $verseEnd;


   public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        $this->entry= ' ';
        $this->language_iso= null;
        $this->bookName= ' ';
        $this->bookID= null;
        $this->testament= null;
        $this->chapterStart= null;
        $this->verseStart= null;
        $this->chapterEnd= null;
        $this->verseEnd= null;
    }

    public function setFromPassage(string $entry, string $language_iso = 'eng'){
        $this->checkEntrySpacing($entry);
        $this->findBookName();
        $this->findBookID();
        $this->getTestament();
        $this->findChapterAndVerses();
        return $this;// this should give us   $this->entry;

    }
    public function setFromDbtArray(array $dbtArray){
        print_r ($dbtArray);
        $entry =$this->checkEntrySpacing ($dbtArray['entry']);
        $this->entry= $entry;
        $this->language_iso=null;
        $this->bookName= $this->findBookName();
        $this->bookID= $dbtArray['bookId'];
        $this->testament= $dbtArray['collection_code'];
        $this->chapterStart= $dbtArray['chapterId'];
        $this->verseStart= $dbtArray['verseStart'];
        $this->chapterEnd= null;
        $this->verseEnd= $dbtArray['verseEnd'];
    }

    private function checkEntrySpacing(string $entry){
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
    private function findBookName(){
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

    private function getTestament(){
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


    private function findChapterAndVerses(){
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
    public function exportPublic(){
            $export= new stdClass();
            $export->entry = $this->entry;
            $export->bookName = $this->bookName;
            $export->bookID = $this->bookID;
            $export->testament = $this->testament;
            $export->chapterStart = $this->chapterStart;
            $export->verseStart = $this->verseStart;
            $export->chapterEnd = $this->chapterEnd;
            $export->verseEnd = $this->verseEnd;
            return  $export;
    }
    public function importPublic($import)
    {
        $this->entry = $import->entry;
        $this->bookName = $import->bookName;
        $this->bookID = $import->bookID;
        $this->testament = $import->testament;
        $this->chapterStart = $import->chapterStart;
        $this->verseStart = $import->verseStart;
        $this->chapterEnd = $import->chapterEnd;
        $this->verseEnd = $import->verseEnd;
    }

}