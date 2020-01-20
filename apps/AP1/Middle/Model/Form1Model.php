<?php

namespace mk2\core;

class Form1Model extends Model{

	private const PROCESS_TOKEN_SALT="f0a9riegjiapfiaoje09f0f0fajiopfAOfij4i4rF93049fjIOFApor098g7094095";

	public function __construct(){

		parent::__construct();

		$this->setValidator([
			"Form1",
		]);

	}

	/**
	 * getCategoryList
	 */
	public function getCategoryList(){

		$categoryList=[
			0=>"TypeA",
			1=>"TypeB",
			2=>"TypeC",
		];

		return $categoryList;
	}

	/**
	 * validate
	 */
	public function validate($post){

		$validate=$this->Validator->Form1->verify($post);

		if($validate){
			return [
				"flg"=>false,
				"validate"=>$validate,
			];
		}
		else
		{
			return [
				"flg"=>true,
				"processToken"=>$this->getProcessToken($post),
			];
		}
	}

	/**
	 * process
	 */
	public function process($post){

		# process Token Check...
		if(!$this->processTokenCheck($post)){
			return false;
		}

		/**
		 * 
		 * 
		 * 
		 * Describe the procedure processing content here....
		 * 
		 * 
		 * 
		 */

		return true;

	}

	/**
	 * (private) getProcessToken
	 */
	 private function getProcessToken($post){
		return hash("sha256",$this::PROCESS_TOKEN_SALT.json_encode($post));
	}
		
	/**
	 * (private) processTokenCheck
	 */
	private function processTokenCheck($data){

		if(!$data){
			return false;
		}

		if(empty($data["post"])){
			return false;
		}

		if(empty($data["processToken"])){
			return false;
		}

		$targetProcessToken=$this->getProcessToken($data["post"]);

		if($targetProcessToken==$data["processToken"]){
			return true;
		}
		else
		{
			return false;
		}
	}

}