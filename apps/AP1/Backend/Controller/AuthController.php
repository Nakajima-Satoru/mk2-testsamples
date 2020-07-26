<?php

/**
 * AuthController
 * 
 * Backend/Controller/AuthController.php
 * 
 * Autholication Controller.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class AuthController extends AppController{

	# constructor

	public function __construct(){
		parent::__construct();

		$this->setPacker([
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
			"Session",
			"SampleAuth",
		])
		->setTable([
			"User",
		])
		->setValidator([
			"Auth",
		]);

		// List of URLs that can be accessed without authentication authority
		$this->Packer->SampleAuth->allowList=[
			"@auth/create",
		];

		// login Check...
		$this->Packer->SampleAuth->loginCheck();

		// send message loading
		if($this->Packer->Session->read("sendMsg")){
			$this->set("sendMsg",$this->Packer->Session->flash("sendMsg"));
		}

	}

	# index

	public function index(){
		$this->set("authData",$this->Packer->SampleAuth->getAuthData());
	}

	# login

	public function login(){

		// For checking if the database can be connected....
		try{
			$this->Table->User->select()->count();
		}catch(\Exception $e){
			$this->render="noDbtable";
			return;
		}

		if(Request::$post){

			// verify check
			if(!$this->Packer->Form->verify()){
				echo "Error! : The process was interrupted because it was determined to be unauthorized access.";
				exit;
			}

			$post=Request::$post;
			
			// validate
			$validate=$this->Validator->Auth->verify($post);

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{


				if($this->Packer->SampleAuth->login($post)){
					$this->redirect("@auth/");

				}
				else{
					$this->Packer->Form->setErrors([
						"username"=>"I cannot log in because my account information does not exist or I do not have permission",
					]);
				}

			}

		}

	}

	# create

	public function create(){

		if(Request::$post){

			// verify check
			if(!$this->Packer->Form->verify()){
				echo "Error! : The process was interrupted because it was determined to be unauthorized access.";
				exit;
			}

			$post=Request::$post;


			// validate
			$validate=$this->Validator->Auth->verify($post,"validate_created");

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{

				// user table create

				try{

					$saveObj=$this->Table->User->save()->tsBegin();

					$saves=[
						"username"=>$post["username"],
						"password"=>$this->Packer->SampleAuth->getPasswordHash($post["password"]),
						"nickname"=>$post["nickname"],
						"email"=>$post["email"],
						"role"=>10,
					];

					$res=$saveObj->save($saves);

				}catch(\Exception $e){
					$saveObj->tsRollback();
					echo $e;
					exit;
				}

				$saveObj->tsCommit();
				
				// send message setting
				$this->Packer->Session->write("sendMsg","Account registration completed");

				return $this->redirect("@auth/login/");

			}
		}
	}

	# logout

	public function logout(){
		$this->autoRender=false;
		
		// logout
		$this->Packer->SampleAuth->logout();

		return $this->redirect("@auth/login/");

	}
}