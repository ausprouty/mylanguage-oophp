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

    protected function findBookID(){
        echo("I am wanting to show $this->bookName");
        $dbh= $this->connect();
        $sth = $dbh->prepare('SELECT book_id FROM bible_book_names
            WHERE (language_iso = :language_iso OR language_iso = :english) AND name = :book_lookup LIMIT 1');
        $sth ->execute (array(':language_iso'=>$this->language_iso, ':english' => 'eng', ':book_lookup'=>$this->bookName ));
        $record = $sth->fetch(PDO::FETCH_COLUMN);
        $this->bookID = $record;


    }

    protected function getTestament(){
        echo ('I am in getTestament<br>');
        echo ("This bookID is $this->bookID <br>");
        $dbh= $this->connect();
        $sth = $dbh->prepare('SELECT testament FROM bible_books
            WHERE book_id = :book_id  LIMIT 1');
        $sth ->execute (array(':book_id'=>$this->bookID ));
        $record = $sth->fetch(PDO::FETCH_COLUMN);
        print_r($record);
        $this->testament = $record;
    }

}