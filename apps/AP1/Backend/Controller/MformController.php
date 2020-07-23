<?php

/**
 * MformController
 * 
 * Backend/Controller/MformController.php
 * 
 * Multi page Form Process sample.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class MformController extends AppController{

	const MFORM_CACHE="__mform_cache__";
	const AUTHORITY_ERROR_MESSAGE="The process was interrupted, judging that it was an unauthorized access.";

	public function __construct(){
		parent::__construct();

		$this->setPacker([
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
			"Session",
		])
		->setValidator([
			"Mform",
		]);

	}

	/**
	 * (private) verify
	 */
	private function _verify($checkTokenName=[]){

		$cache=$this->Packer->Session->read(self::MFORM_CACHE);

		if($cache){
			
			if($checkTokenName){

				$juge=true;

				// data exist check
				foreach($checkTokenName as $ctn_){
					if(empty($cache[$ctn_])){
						$juge=false;
					}
				}

				if($juge){
					return $cache;
				}
				else
				{
					if(Request::$params["action"]!="step1"){
						$this->redirect("@mform/step1/");
					}
				}
			}
			else
			{
				return $cache;
			}

		}
		else
		{
			if(Request::$params["action"]!="step1"){
				$this->redirect("@mform/step1");
			}
		}

	}

	/**
	 * step1
	 */
	public function step1(){

		// cache data check
		$cache=$this->_verify();

		if(Request::$post){

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			$post=Request::$post;

			// validate check
			$vres=$this->Validator->Mform->verify($post,"v_step1");

			if($vres){
				$this->PackerUI->Form->setErrors($vres);
			}
			else
			{
				$cache["step1"]=$post;
				$this->Packer->Session->write(self::MFORM_CACHE,$cache);
				$this->redirect("@mform/step2/");
			}

		}
		else{

			if(!empty(Request::$get["data_keep"])){
				if(!empty($cache["step1"])){
					Request::$post=$cache["step1"];
				}
			}

		}

	}

	/**
	 * step2
	 */
	public function step2(){

		$cache=$this->_verify([
			"step1",
		]);

		if(Request::$post){

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			$post=Request::$post;

			// validate check
			$vres=$this->Validator->Mform->verify($post,"v_step2");

			if($vres){
				$this->PackerUI->Form->setErrors($vres);
			}
			else
			{
				$cache["step2"]=$post;
				$this->Packer->Session->write(self::MFORM_CACHE,$cache);
				$this->redirect("@mform/step3/");
			}

		}
		else{

			if(!empty(Request::$get["data_keep"])){
				if(!empty($cache["step2"])){
					Request::$post=$cache["step2"];
				}
			}
		}

	}

	/**
	 * step3	
	 */
	public function step3(){

		$cache=$this->_verify([
			"step1",
			"step2",
		]);

		if(Request::$post){

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			$post=Request::$post;

			// validate check
			$vres=$this->Validator->Mform->verify($post,"v_step3");

			if($vres){
				$this->PackerUI->Form->setErrors($vres);
			}
			else
			{
				$cache["step3"]=$post;
				$this->Packer->Session->write(self::MFORM_CACHE,$cache);
				$this->redirect("@mform/step4/");
			}

		}
		else{

			if(!empty(Request::$get["data_keep"])){
				if(!empty($cache["step3"])){
					Request::$post=$cache["step3"];
				}
			}
		}

	}


	/**
	 * step4
	 */
	public function step4(){

		$cache=$this->_verify([
			"step1",
			"step2",
			"step3",
		]);

		if(Request::$post){

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			$post=Request::$post;

			// validate check
			$vres=$this->Validator->Mform->verify($post,"v_step4");

			if($vres){
				$this->PackerUI->Form->setErrors($vres);
			}
			else
			{
				$cache["step4"]=$post;
				$this->Packer->Session->write(self::MFORM_CACHE,$cache);
				$this->redirect("@mform/confirm/");
			}

		}
		else{

			if(!empty(Request::$get["data_keep"])){
				if(!empty($cache["step4"])){
					Request::$post=$cache["step4"];
				}
			}
		}

	}

	/**
	 * confirm
	 */
	public function confirm(){

		$cache=$this->_verify([
			"step1",
			"step2",
			"step3",
			"step4",
		]);

		$this->set("cache",$cache);

		if(Request::$post){
			
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			/**
			 *
			 * Perform the procedure here (scheduled)...
			 *  
			 * 
			 */

			$cache["complete"]=$post;
			$this->Packer->Session->write(self::MFORM_CACHE,$cache);
			$this->redirect("@mform/complete/");

		}
	}

	/**
	 * complete
	 */

	 public function complete(){

		$cache=$this->_verify([
			"step1",
			"step2",
			"step3",
			"step4",
			"complete",
		]);

		//cache clear
		$this->Packer->Session->delete(self::MFORM_CACHE);
		
	 }

}