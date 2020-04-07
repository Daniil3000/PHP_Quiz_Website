<?php


class Users extends MainController
{
    private $model;

    public function __construct(){
        parent::__construct();
        $this->model = new UserModel($this->db);
    }

    public function registerForm() {
        if ($this->isLoggedIn()){
            $this->f3->reroute("/");
        } else {
            echo $this->f3->get('twig')->render("register.twig");
        }

    }

    public function registerAction(){
        // validate posted data
        if ($this->isFieldEmpty($this->f3->get('POST.name')) || $this->isFieldEmpty($this->f3->get('POST.email')) || $this->isFieldEmpty($this->f3->get('POST.pass'))){
            $message = "Please fill all the fields";
        } else if(!filter_var($this->f3->get('POST.email'), FILTER_VALIDATE_EMAIL)){
            $message = "Please provide a valid email";
        } else { // posted data is correct
            // encrypt posted password
            $encPass= password_hash( $this->f3->get('POST.pass'), PASSWORD_BCRYPT );

            // add a "fake" POST element so that we can update the DB
            $this->f3->set('POST.password', $encPass);

            // add a message to our session
            $_SESSION['success'] = "User " . $this->f3->get('POST.name') ." created. Now you can log in using your email and password";
            // add a record to DB
            $this->model->add( );
            // reroute to homepage
            $this->f3->reroute("/");
            die();
        }
        // some of the posted data was invalid
        $this->twigData["name"] = $this->f3->get('POST.name');
        $this->twigData["email"] = $this->f3->get('POST.email');
        $this->twigData["message"] = $message;
        echo $this->f3->get('twig')->render("register.twig", $this->twigData);
    }



    public function loginForm(){
        if ($this->isLoggedIn()){
            $this->f3->reroute("/");
        } else{
            echo $this->f3->get('twig')->render("login.twig");
        }

    }

    public function loginAction(){
        // validate posted data
        if ($this->isFieldEmpty($this->f3->get('POST.email')) || $this->isFieldEmpty($this->f3->get('POST.pass'))){
            $message = "Please fill all the fields";
        } else if(!filter_var($this->f3->get('POST.email'), FILTER_VALIDATE_EMAIL)){
            $message = "Please provide a valid email";
        } else{ // check if we have provided credentials in our DB
            $user = $this->model->getByEmail($this->f3->get('POST.email'));
            // check if we have a result for this query
            if (!isset($user)){
                $message = "User with a provided email is not registered on our site";
            } else { // user exists - compare passwords
                if (!password_verify($this->f3->get('POST.pass'), $user['password'])) {
                    $message = "Password is incorrect";
                } else { // we can log in
                    // add a user to our session
                    $_SESSION['name'] = $user['name'];
                    // add a message to our session
                    $_SESSION['success'] = "Hello " . $user['name'] ."! Now you can enjoy our quizzes";
                    // reroute to homepage
                    $this->f3->reroute("/");
                    die();
                }
            }
        }
        // some of the provided data was invalid - send user to the same page with filled fields
        $this->twigData["email"] = $this->f3->get('POST.email');
        $this->twigData["message"] = $message;
        echo $this->f3->get('twig')->render("login.twig", $this->twigData);
    }

    public function logoutAction(){

        // remove all existing session data
        session_destroy();
        session_unset();
        // redirect
        $this->f3->reroute("/");
    }
}