<?php

class DbsQuestion extends DbConnection {

    private $id;
    private $topicId;
    private $topic;
    private $questionNumber;
    private $question;
    private $hlId;

    public function __construct($id = null, $topicId = null, $topic= null, $questionNumber= null, $question=null, $hlId= null) {
        $this->id = $id;
        $this->topicId = $topicId;
        $this->topic = $topic;
        $this->questionNumber = $questionNumber;
        $this->question = $question;
        $this->hlId = $hlId;
    }

    public function findByHL($id)
    {
    $dbh= $this->connect();
    $sth = $dbh->prepare('SELECT * FROM dbs_question WHERE hl_id = :hl_id ORDER BY question_number');
    $sth ->execute (array('hl_id'=>$id));
    $record = $sth->fetchAll(PDO::FETCH_ASSOC);
    return ($record);
    }


    // Getters and setters for each property

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTopicId() {
        return $this->topicId;
    }

    public function setTopicId($topicId) {
        $this->topicId = $topicId;
    }

    public function getTopic() {
        return $this->topic;
    }

    public function setTopic($topic) {
        $this->topic = $topic;
    }

    public function getQuestionNumber() {
        return $this->questionNumber;
    }

    public function setQuestionNumber($questionNumber) {
        $this->questionNumber = $questionNumber;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }

    public function getHlId() {
        return $this->hlId;
    }

    public function setHlId($hlId) {
        $this->hlId = $hlId;
    }
}