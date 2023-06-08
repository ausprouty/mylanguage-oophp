<?php

class DbsQuestion extends DbConnection {

    private $id;
    private $topicId;
    private $topic;
    private $questionNumber;
    private $question;
    private $hlId;

    public function __construct($id, $topicId, $topic, $questionNumber, $question, $hlId) {
        $this->id = $id;
        $this->topicId = $topicId;
        $this->topic = $topic;
        $this->questionNumber = $questionNumber;
        $this->question = $question;
        $this->hlId = $hlId;
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
?>

}