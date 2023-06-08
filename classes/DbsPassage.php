<?php


class DbsPassage {
    private $lesson;
    private $dbtArray;
    private $reference;
    private $description;

    public function __construct($lesson, $dbtArray, $reference, $description) {
        $this->lesson = $lesson;
        $this->dbtArray = $dbtArray;
        $this->reference = $reference;
        $this->description = $description;
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
