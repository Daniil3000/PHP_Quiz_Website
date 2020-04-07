<?php


class QuestionModel extends DB\SQL\Mapper
{
    public function __construct(DB\SQL $db){
        parent::__construct($db, 'quiz_questions');
    }

    /**
     * Fetch all the records from the table
     *
     * @return [array] results
     */
    public function fetchAll(){
        $this->load();
        return $this->query;
    }

    /**
     * Fetch a question with a specific id
     *
     * @param [int] $id
     * @return mixed - a single result of the query
     */
    public function getById($id){
        if (is_numeric($id)){
            $this->load(array("id=?", $id));
            $query = $this->query;
            return $query[0];
        }
    }

    public function getQuestionsByQuizId($quizId){
        if (is_numeric($quizId)){
            $this->load(array("quiz_id=?", $quizId));
            return $this->query;

        }
    }

}