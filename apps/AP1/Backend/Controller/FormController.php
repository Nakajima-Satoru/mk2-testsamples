<?php

/**
 * FormController
 * 
 * Backend/Controller/FormController.php
 * 
 * Form Page..
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class FormController extends AppController{

	public const FORM_SESSION_CACHE="__cache__form1";

	public function __construct(){

		parent::__construct();

		$this->setPacker([
			"Session",
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
		])
		->setModel([
			"Form1",
		]);

	}

	# index

	public function index(){

		# Get list of categories and set to View
		$this->set("categoryList",$this->Model->Form1->getCategoryList());

		if(Request::$post){

			# token verify...
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : Request Access Error";
				exit;
			}

			$post=Request::$post;

			# post data validation
			$res=$this->Model->Form1->validate($post);
			
			if(!empty($res["validate"])){

				# If there is a validation error, return the result in Form tag.
				$this->PackerUI->Form->setErrors($res["validate"]);

			}
			else
			{

				# Keep post data in Session temporarily
				$this->Packer->Session->write($this::FORM_SESSION_CACHE,[
					"post"=>$post,
					"processToken"=>$res["processToken"],
				]);

				# Redirect to confirmation screen
				$this->redirect("@form/confirm");

			}
		}
		else{

			# Acquire the temporarily saved post data in Session data
			$cache=$this->Packer->Session->read($this::FORM_SESSION_CACHE);

			# If there is data held in Session, it is reflected in Form tag.
			if(!empty($cache["post"])){
				Request::$post=$cache["post"];
			}

		}

	}

	# confirm
	
	public function confirm(){

		# Check temporarily saved data in Session data
		$cache=$this->Packer->Session->read($this::FORM_SESSION_CACHE);

		if(empty($cache["post"])){

			# If there is no temporarily saved data, it is forced to redirect to the form screen.
			$this->redirect("@form");

		}

		# Set temporarily saved data to View
		$this->set("cache",$cache["post"]);

		# set categoryList
		$this->set("categoryList",$this->Model->Form1->getCategoryList());

		if(Request::$post){

			# post requested...

			# token verify...
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : Request Access Error";
				exit;
			}

			$post=Request::$post;

			# process....
			$res=$this->Model->Form1->process($cache);

			# ckear cache...
			$this->Packer->Session->delete($this::FORM_SESSION_CACHE);

			if($res){
				# successed.
				$this->redirect("@form/complete");
			}
			else
			{
				# failed.
				echo "ERROR! : The procedure failed.";
				exit;
			}
		}
	}

	public function complete(){}
}