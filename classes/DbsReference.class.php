<?php

//todo  I think this needs a rewrite
class DbsReference extends DbConnection{
    private $lesson;
    private $dbtArray;
    private $reference;
    private $description;

    public function __construct($lesson = null, $dbtArray= null, $reference= null, $description= null) {
        $this->lesson = $lesson;
        $this->dbtArray = $dbtArray;
        $this->reference = $reference;
        $this->description = $description;
    }

 public function findByHL($hl_id)
    {
    $dbh= $this->connect();
    $sth = $dbh->prepare('SELECT * FROM dbs_reference ORDER BY lesson');
    $sth ->execute ();
    $record = $sth->fetchAll(PDO::FETCH_ASSOC);
    return ($record);
    }

    // Getters and setters for each property

    public function getLesson() {
        return $this->lesson;
    }

    public function setLesson($lesson) {
        $this->lesson = $lesson;
    }

    public function getDbtArray() {
        return $this->dbtArray;
    }

    public function setDbtArray($dbtArray) {
        $this->dbtArray = $dbtArray;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
?>
