<?php

class DbsQuestion  {
    private $dbConnection;
    private $id;
    private $topicId;
    private $topic;
    private $questionNumber;
    private $question;
    private $hlId;

    public function __construct() {
      $this->dbConnection = new DatabaseConnection();

    }


    public function findByHL($id){
        $query = "SELECT * FROM dbs_questions WHERE hl_id = :hl_id ORDER BY question_number";
        $params = array('hl_id'=>$id);
        try {
            $statement = $this->dbConnection->executeQuery($query, $params);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
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