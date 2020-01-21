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

	public function __construct(){
		parent::__construct();

		$this->setPacker([
			"Auth",
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
		])
		->setTable([
			"User",
		])
		->setValidator([
			"Auth",
		]);

		$this->Packer->Auth->allowList=[
			"@auth/create",
		];
		$this->Packer->Auth->loginCheck();

	}

	public function index(){

	}
	public function login(){

		//データベースが接続できるかチェック用....
		try{
			$this->Table->User->select()->count();
		}catch(\Exception $e){
			$this->render="noDbtable";
			return;
		}

		if(Request::$post){
			$post=Request::$post;

			// verify check
			if(!$this->Packer->Form->verify()){
				echo "Error! : 不正なアクセスと判断し、処理を中断しました。";
				exit;
			}

			$validate=$this->Validator->Auth->verify($post);

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else{


				if($this->Packer->Auth->login($post)){


				}
				else{
					$this->Packer->Form->setErrors([
						"autholity"=>"ログインできませんでした",
					]);
				}

			}

		}

	}

	public function create(){

	}
}