<?php
session_start();
// composer autoload
require "vendor/autoload.php";

// create an instance of the framework
$f3 = Base::instance();

// TWIG
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

//set twig for f3
$f3->set("twig", $twig);

// setup the route to config
$f3->config('config/setup.ini');

// setup our routes
$f3->route('GET /', 'Page->home');
$f3->route('GET /errorpage', 'Page->errorPage');

// Users
$f3->route('GET /register', 'Users->registerForm');
$f3->route('POST /register', 'Users->registerAction');
$f3->route('GET /login', 'Users->loginForm');
$f3->route('POST /login', 'Users->loginAction');
$f3->route('GET /logout', 'Users->logoutAction');

// Quizzes
$f3->route('GET /quiz/@quiz_id/@question_id', 'Quizzes->render');
$f3->route('POST /quiz/@quiz_id/@question_id', 'Quizzes->switchQuestion');
$f3->route('GET /quiz/@quiz_id/result', 'Quizzes->result');

// error handling
$f3->set('ONERROR', function ($f3){
    if ($f3->get('ERROR.code') == "404"){
        $_SESSION['error'] = "Error 404. Page not found";
        echo $f3->reroute('/errorpage');
    } else {
        echo $f3->get('ERROR.code') . " - " . $f3->get('ERROR.status') . "<br/>" . $f3->get('ERROR.text');
    }
});



// run f3
$f3->run();