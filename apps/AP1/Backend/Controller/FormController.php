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

		$this->set("categoryList",$this->Model->Form1->getCategoryList());

		if(Request::$post){
			$post=Request::$post;

			# token verify...
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : 不正なアクセスと判断し、処理を中断いたしました。";
				exit;
			}

			$res=$this->Model->Form1->validate($post);
			
			if(!empty($res["validate"])){
				$this->PackerUI->Form->setErrors($res["validate"]);
			}
			else
			{
				$this->Packer->Session->write($this::FORM_SESSION_CACHE,[
					"post"=>$post,
					"processToken"=>$res["processToken"],
				]);
				$this->redirect("@form/confirm");

			}
		}
		else{

			$cache=$this->Packer->Session->read($this::FORM_SESSION_CACHE);
			if(!empty($cache["post"])){
				Request::$post=$cache["post"];
			}

		}

	}

	# confirm
	
	public function confirm(){

		# cache check....
		$cache=$this->Packer->Session->read($this::FORM_SESSION_CACHE);
		if(empty($cache["post"])){
			$this->redirect("@form");
		}
		$this->set("cache",$cache["post"]);

		# set categoryList
		$this->set("categoryList",$this->Model->Form1->getCategoryList());

		if(Request::$post){
			# post requested...

			$post=Request::$post;

			# token verify...
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : 不正なアクセスと判断し、処理を中断いたしました。";
				exit;
			}

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
				echo "ERROR! : 何らかの原因で手続きに失敗しました";
				exit;
			}
		}
	}

	public function complete(){


	}
}