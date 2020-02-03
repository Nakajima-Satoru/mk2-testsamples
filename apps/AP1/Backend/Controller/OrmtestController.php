<?php

/**
 * OrmtestController
 * 
 * Backend/Controller/OrmtestController.php
 * 
 * Top page or other screen controller.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class OrmtestController extends AppController{

	public $autoRender=false;

	public function __construct(){
		parent::__construct();

		$this->setTable([
			"Table1",
		]);

	}

	# Top page
	public function index(){
		$this->autoRender=true;
	}

	# select test
	public function select1(){

		echo "<p>1.get all recode.</p>";
		echo "<pre>";
		echo '$this->Table->Table1->select()->all();';
		echo "\n";
		
		$res=$this->Table->Table1->select()->all();
		print_r($res);

		echo "</pre>";

	}


}