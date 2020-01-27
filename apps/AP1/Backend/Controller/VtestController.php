<?php

/**
 * MainController
 * 
 * Backend/Controller/MainController.php
 * 
 * Top page or other screen controller.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class VtestController extends AppController{

	public function __construct(){
		parent::__construct();

		$this->setValidator([
			"Vtest",
		])
		->setPacker([
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
		]);

	}

	# pattern1
	public function index(){

		if(Request::$post){
			$post=Request::$post;

			if(!$this->Packer->Form->verify()){
				echo "ERROR : Judge as unauthorized access and suspend processing";
				exit;
			}

			$validate=$this->Validator->Vtest->verify($post);

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{

				echo "Request Success!";
				echo "<pre>";
				print_r($post);
				echo "</pre>";
				exit;
			}
		}

	}

	# pattern2
	public function pattern2(){

		if(!empty(Request::$get["get_cvscript"])){
			$this->autoRender=false;
			header("Content-Type: text/javascript");
			$cvScript=$this->Validator->Vtest->getCvScript();
			return $cvScript;
		}

		$cvCache=$this->Validator->Vtest->getCvCache();
		$this->set("cvCache",$cvCache);

		if(Request::$post){
			$post=Request::$post;

			if(!$this->Packer->Form->verify()){
				echo "ERROR : Judge as unauthorized access and suspend processing";
				exit;
			}

			$validate=$this->Validator->Vtest->verify($post);

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{

				echo "Request Success!";
				echo "<pre>";
				print_r($post);
				echo "</pre>";
				exit;
			}
		}

	}
}