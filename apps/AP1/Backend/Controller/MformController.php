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

	private const MFORM_CACHE="__mform_cache__";

	private const MFORM_PARITY_SALT="foaire09fafaff78da0f987g0a9f711adoifjAOIFefag33f9f80ag";

	public function __construct(){
		parent::__construct();

		$this->setPacker([
			"Session",
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
		])
		->setValidator([
			"Mform",
		]);

	}

	/**
	 * step1
	 */
	public function step1(){

		$cache=$this->verify();


		if(Request::$post){
			$post=Request::$post;

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : 不正アクセスと判断して、処理を中断しました。";
				exit;
			}

			unset($post["__token"]);

			$validate=$this->Validator->Mform->verify($post,"v_step1");

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else
			{
				$cache["step1"]=$post;
				$cache["step1_token"]=$this->setParityToken($post);
				$this->Packer->Session->write($this::MFORM_CACHE,$cache);
				$this->redirect("@mform/step2");
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

		$cache=$this->verify([
			"step1",
		]);

		if(Request::$post){
			$post=Request::$post;

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : 不正アクセスと判断して、処理を中断しました。";
				exit;
			}

			unset($post["__token"]);

			$validate=$this->Validator->Mform->verify($post,"v_step2");

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else
			{
				$cache["step2"]=$post;
				$cache["step2_token"]=$this->setParityToken($post);
				$this->Packer->Session->write($this::MFORM_CACHE,$cache);
				$this->redirect("@mform/step3");
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

		$cache=$this->verify([
			"step1",
			"step2",
		]);

		if(Request::$post){
			$post=Request::$post;

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : 不正アクセスと判断して、処理を中断しました。";
				exit;
			}

			unset($post["__token"]);

			$validate=$this->Validator->Mform->verify($post,"v_step3");

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else
			{
				$cache["step3"]=$post;
				$cache["step3_token"]=$this->setParityToken($post);
				$this->Packer->Session->write($this::MFORM_CACHE,$cache);
				$this->redirect("@mform/step4");
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

		$cache=$this->verify([
			"step1",
			"step2",
			"step3",
		]);

		if(Request::$post){
			$post=Request::$post;

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : 不正アクセスと判断して、処理を中断しました。";
				exit;
			}

			unset($post["__token"]);

			$validate=$this->Validator->Mform->verify($post,"v_step4");

			if($validate){
				$this->PackerUI->Form->setErrors($validate);
			}
			else
			{
				$cache["step4"]=$post;
				$cache["step4_token"]=$this->setParityToken($post);
				$this->Packer->Session->write($this::MFORM_CACHE,$cache);
				$this->redirect("@mform/confirm");
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

		$cache=$this->verify([
			"step1",
			"step2",
			"step3",
			"step4",
		]);

		$this->set("cache",$cache);

		if(Request::$post){
			
			$post=Request::$post;

			if(!$this->Packer->Form->verify()){
				echo "ERROR : 不正アクセスと判断して、処理を中断しました。";
				exit;
			}

			/**
			 *
			 * ここで手続きを実行(予定)....
			 *  
			 * 
			 */

			$cache["complete"]=$post;
			$cache["complete_token"]=$this->setParityToken($post);
			$this->Packer->Session->write($this::MFORM_CACHE,$cache);
			$this->redirect("@mform/complete");

		}
	}

	/**
	 * complete
	 */

	 public function complete(){

		$cache=$this->verify([
			"step1",
			"step2",
			"step3",
			"step4",
			"complete",
		]);

		//cache clear
		$this->Packer->Session->delete($this::MFORM_CACHE);
		
	 }


	/**
	 * (private) setParityToken
	 */
	public function setParityToken($data){
		return hash("sha256",json_encode($data).$this::MFORM_PARITY_SALT);
	}

	/**
	 * (private) verify
	 */
	public function verify($checkTokenName=[]){

		if($cache=$this->Packer->Session->read($this::MFORM_CACHE)){
			
			if($checkTokenName){
				$juge=true;
				foreach($checkTokenName as $ctn_){
					if(!empty($cache[$ctn_]) && !empty($cache[$ctn_."_token"])){
						$getParityToken=$cache[$ctn_."_token"];

						$recheckToken=$this->setParityToken($cache[$ctn_]);

						if($recheckToken!=$getParityToken){
							$juge=false;
						}
					}
					else
					{
						$juge=false;
					}
				}

				if($juge){
					return $cache;
				}
				else
				{
					if(Request::$params["action"]!="step1"){
						$this->redirect("@mform/step1");
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

}