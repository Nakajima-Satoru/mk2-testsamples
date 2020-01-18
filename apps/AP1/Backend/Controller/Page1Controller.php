<?php
namespace mk2\core;

Import::Controller("App");

class Page1Controller extends AppController{

    public function index(){


    }
    public function arg1($aregment1){
        $this->set("arg1",$aregment1);
    }
}