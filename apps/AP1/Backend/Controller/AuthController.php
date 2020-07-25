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

		$this->Packer->SampleAuth->allowList=[
			"@auth/create",
		];
		$this->Packer->SampleAuth->loginCheck();

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

		//データベースが接続できるかチェック用....
		try{
			$this->Table->User->select()->count();
		}catch(\Exception $e){
			$this->render="noDbtable";
			return;
		}

		if(Request::$post){

			// verify check
			if(!$this->Packer->Form->verify()){
				echo "Error! : 不正なアクセスと判断し、処理を中断しました。";
				exit;
			}

			$post=Request::$post;
			
			$validate=$this->Validator->Auth->verify($post);

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{


				if($this->Packer->SampleAuth->login($post)){
					$this->redirect("@auth");

				}
				else{
					$this->Packer->Form->setErrors([
						"autholity"=>"ログインできませんでした",
					]);
				}

			}

		}

	}

	# create

	public function create(){

		if(Request::$post){
			$post=Request::$post;

			// verify check
			if(!$this->Packer->Form->verify()){
				echo "Error! : 不正なアクセスと判断し、処理を中断しました。";
				exit;
			}

			$validate=$this->Validator->Auth->verify($post,"validate_created");

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{

				try{
					$saveObj=$this->Table->User->save();

					$saveObj->tsBegin();

					$saves=[
						"username"=>$post["username"],
						"password"=>$this->Packer->Auth->getPasswordHash($post["password"]),
						"nickname"=>$post["nickname"],
						"email"=>$post["email"],
					];

					$res=$saveObj->save($saves);

				}catch(\Exception $e){
					$saveObj->tsRollback();
					echo $e;
					exit;
				}

				$saveObj->tsCommit();
				
				$this->Packer->Session->write("sendMsg","アカウントの登録が完了しました");
				$this->redirect("@auth/login");

			}
		}
	}

	# logout

	public function logout(){
		$this->autoRender=false;
		
		$this->Packer->SampleAuth->logout();

		$this->redirect("@auth/login");
	}
}