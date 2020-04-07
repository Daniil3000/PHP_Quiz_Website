<?php


class Page extends MainController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function home(){
        echo $this->f3->get('twig')->render("index.twig", $this->twigData);
    }

    public function errorPage(){

        echo $this->f3->get('twig')->render("errorpage.twig", $this->twigData);
    }

}