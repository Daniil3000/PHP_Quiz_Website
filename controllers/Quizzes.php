<?php


class Quizzes extends MainController
{
    private $quiz;
    private $question;

    public function __construct(){
        parent::__construct();

        $this->quiz = new QuizModel($this->db);
        $this->question = new QuestionModel($this->db);
    }


    public function render($f, $params){

        // if user not logged in - reroute him home
        if (!$this->isLoggedIn()){
            $this->f3->reroute("/");
            die();
        }
        // set up session var for storing answers
        if($params['question_id'] == 1){ // only set it up when we're at the 1st question
            $_SESSION['answers'] = array();
        }
        // fetching quiz details
        $quizDetails = $this->quiz->getById($params['quiz_id']); // object
        // fetching questions and answers for current quiz
        $quizData = $this->question->getQuestionsByQuizId($params['quiz_id']); // array of objects
        // getting current question object
        $currentQuestion = $quizData[$params['question_id']-1];
        // check if provided params are correct
        if (!isset($quizDetails) || !isset($currentQuestion)){
            $_SESSION['error'] = "Provided URL doesn't exist on this site";
            $this->f3->reroute("/errorpage");
            die();
        } else {
            // set up template data
            $this->twigData['quiz'] = $quizDetails;
            $this->twigData['question'] = $quizData[$params['question_id']-1]->question;
            $this->twigData['answers'] = $this->getAnswers($params['quiz_id'], $params['question_id']);
            echo $this->f3->get('twig')->render('quiz.twig', $this->twigData);
        }
    }

    public function getAnswers($quizId, $questionId){
        // fetching all questions data for needed quiz
        $allQuestionsData = $this->question->getQuestionsByQuizId($quizId);
        // getting question depending on question id
        $currentQuestionData = $allQuestionsData[$questionId-1];
        // getting wrong answers for current question
        $wrongAnswers = explode("::", $currentQuestionData->wrong_answers);

        $allAnswers = array();
        // adding wrong answers to answers array
        foreach ($wrongAnswers as $wrongAnswer) {
            array_push($allAnswers, $wrongAnswer);
        }
        // adding correct answer to answers array
        $correctAnswer = $currentQuestionData->correct_answer;
        array_push($allAnswers, $correctAnswer);
        // mixing answers inside our array
        shuffle($allAnswers);
        return $allAnswers;
    }

    public function switchQuestion($f, $params){
        // get current page from route params
        $page = $params['question_id'];
        // add user's answer to the session array with answers
        array_push($_SESSION['answers'], $this->f3->get('POST.btnAnswer'));
        // increment page/question number
        $page++;
        // fetch all questions for current quuiz
        $quizData = $this->question->getQuestionsByQuizId($params['quiz_id']);
        // check if next page number is greater than number of questions in the quiz
        if($page<=count($quizData)){
            $this->f3->reroute("/quiz/".$params['quiz_id']."/$page");
        } else {
            $this->f3->reroute("/quiz/".$params['quiz_id']."/result");
        }
    }

    public function result($f, $params){
        // set up twig data
        $this->twigData["result"] = $this->getResultString($params['quiz_id'], $_SESSION['answers']);
        $this->twigData['score'] = $_SESSION['score'];
        echo $this->f3->get('twig')->render('result.twig', $this->twigData);
    }

    /**
     * Show results with given and correct answers
     * @param [int] $quiz_id
     * @param [array] $answers
     * @return string
     */
    public function getResultString($quiz_id, $answers) {
        $resultString = "";
        $result = $this->checkResult($quiz_id, $answers);
        foreach ($result as $question => $answer) {
            $resultString.="<p class='text-light bg-dark'>$question</p>";
            if (is_array($answer)){
                foreach ($answer as $key => $value) {
                    if ($key == "wrong_answer"){
                        $resultString.="<p>Your answer is <span class='text-danger'>$value</span></p>";
                    }
                    if ($key == "correct_answer") {
                        $resultString.="<p>Correct answer is <span class='text-info'>$value</span></p>";
                    }
                }
            } else {
                $resultString.="<p>Your answer is correct! <span class='text-success'>$answer</span></p>";
            }
        }
        return $resultString;
    }

    /**
     * Check user's answers
     * @param [int] $quiz_id
     * @param [array] $answers
     * @return [array] result
     */
    public function checkResult($quiz_id, $answers) {
        // set up array for the result
        $result = array();
        // set up score variable
        $scoreCounter = 0;
        // fetching all questions data for needed quiz
        $allQuestionsData = $this->question->getQuestionsByQuizId($quiz_id);
        // if route is incorrect or user skipped questions
        if (count($allQuestionsData) == 0 || count($allQuestionsData) != count($answers)){
            $_SESSION['error'] = "Something went wrong during the quiz. Please start over.";
            $this->f3->reroute("/errorpage");
            die();
        }
        for ($i = 0; $i<count($allQuestionsData); $i++) {
            // if the answer is correct
            if ($allQuestionsData[$i]->correct_answer == $answers[$i]){
                // add question and correct answer to result array as key => value
                $result[$allQuestionsData[$i]->question] = $answers[$i];
                // increment score counter
                $scoreCounter++;
            } else { // the answer is incorrect
                $result[$allQuestionsData[$i]->question] = array('wrong_answer' => $answers[$i], 'correct_answer' => $allQuestionsData[$i]->correct_answer);
            }
        }
        // write score to the session
        $_SESSION['score'] = $scoreCounter/count($allQuestionsData)*100;
        // return result
        return $result;
    }

}