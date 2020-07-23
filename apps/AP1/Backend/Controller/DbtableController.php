<?php

/**
 * DbtableController
 * 
 * Backend/Controller/DbtableController.php
 * 
 * Database Table Control Basic
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class DbtableController extends AppController{

	const FORM_CACHE="__cache_dbtable1_edit";

	public function __construct(){
		parent::__construct();

		$this->setModel([
			"Dbtable1",
		])
		->setPacker([
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
			"Session",
			"Paginate",
		]);

		$this->set("sendMsg",$this->Packer->Session->flash("sendMsg"));
		$this->set("dangerMsg",$this->Packer->Session->flash("dangerMsg"));

	}

	/**
	 * index(list)
	 */
	public function index(){

		// search recode..
		$res=$this->Model->Dbtable1->get(null,Request::$get);
		$this->set("res",$res);

	}

	/**
	 * edit/register
	 */
	public function edit($id=null){

		if(Request::$post){

			// if Request Data(POST) then...

			//verify check
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : Processing was interrupted due to unauthorized access.";
				exit;
			}

			$post=Request::$post;

			$post["id"]=$id;

			// input data validate..
			$vres=$this->Model->Dbtable1->validate($post);

			if($vres){

				// output validate error message..
				$this->Packer->Form->setErrors($vres);

			}
			else
			{

				// write session cache..
				$this->Packer->Session->write(self::FORM_CACHE,$post);

				// next confirm page..
				return $this->redirect("@dbtable/confirm/");

			}

		}
		else
		{

			// if no exist Request Data(POST) then...

			if($id){

				// get recode data...
				$res=$this->Model->Dbtable1->get($id);

				if(!empty($res)){
					Request::$post=(array)$res;
				}
				else{
					$this->Packer->Session->write("dangerMsg","Editing stopped because no records were found.");
					return $this->redirect("@dbtable/");
				}
			}

			if(!empty(Request::$get["data_keep"])){
				$cache=$this->Packer->Session->read(self::FORM_CACHE);
				Request::$post=$cache;
			}


		}

	}

	# confirm 

	public function confirm(){

		// cache check
		$cache=$this->Packer->Session->read(self::FORM_CACHE);
		if(!$cache){
			$this->redirect("@dbtable/register/");
		}

		$this->set("cache",$cache);

		if(Request::$post){

			//verify check
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : Processing was interrupted due to unauthorized access.";
				exit;
			}
	
			// recode insert/update process
			$res=$this->Model->Dbtable1->process($cache);
	
			$this->Packer->Session->delete(self::FORM_CACHE);
					
			if(!empty($res["flg"])){
				$this->Packer->Session->write("sendMsg","Record update/registration completed");
			}
			else{
				$this->Packer->Session->write("dangerMsg","Record update/registration failed. <br>Error : ".$res["error"]);
			}
			return $this->redirect("@dbtable/");
	
		}
	}

	# delete

	public function delete($id){
		$this->autoRender=false;

		$res=$this->Model->Dbtable1->delete($id);

		if(!empty($res["flg"])){
			$this->Packer->Session->write("sendMsg","One record deleted");
		}
		else{
			$this->Packer->Session->write("dangerMsg","Deletion of record failed. \n".$res["error"]);
		}
		$this->redirect("@dbtable");

	}

}