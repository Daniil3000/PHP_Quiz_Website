<?php


class MainController
{
    protected $f3;
    protected $db;
    public $twigData;
    private $quizzes;

    public function __construct(){
        $c_f3 = Base::instance();
        $c_db = new DB\SQL($c_f3->get('dbHost'), $c_f3->get('dbUser'), $c_f3->get('dbPass'));

        $this->f3 = $c_f3;
        $this->db = $c_db;
        $quizModel = new QuizModel($this->db);
        // fetch all available quizzes
        $this->quizzes = $quizModel->fetchAll();
        // set up common twig data for all pages
        $this->twigData = array("message" => $_SESSION['message'], "error" => $_SESSION['error'], "success" => $_SESSION['success'], "isLoggedIn" => $this->isLoggedIn(), "username" => $this->isLoggedIn()? $_SESSION['name'] : "", "quizzes" => $this->quizzes, "year" => date("Y"));
        unset($_SESSION['message']);
        unset($_SESSION['error']);
        unset($_SESSION['success']);
    }

    /**
     * Cjeck if the user is logged in
     * @return bool
     */
    function isLoggedIn() {
        return isset($_SESSION['name']);
    }

    /**
     * Validate if a field is empty
     *
     * @param [string] $field
     * @return boolean
     */
    public function isFieldEmpty( $field ){
        return ( !isset( $field ) || trim( $field ) == "" );
    }



}