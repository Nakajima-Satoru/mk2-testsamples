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

	private $formCache="__cache_dbtable1_edit";

	public function __construct(){
		parent::__construct();

		$this->setModel([
			"Dbtable1",
		])
		->setPacker([
			"Form",
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
		$this->set("res",$this->Model->Dbtable1->search(Request::$get));

	}

	/**
	 * edit/register
	 */
	public function edit($id=null){

		if(Request::$post){

			// if Request Data(POST) then...

			$post=Request::$post;

			//verify check
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : Processing was interrupted due to unauthorized access.";
				exit;
			}

			if($id){
				$post["id"]=$id;
			}

			// input data validate..
			$res=$this->Model->Dbtable1->validate($post);

			if(!empty($res["error"])){
				// output validate error message..
				$this->Packer->Form->setErrors($res["validate"]);
			}
			else
			{
				$cache=[
					"post"=>$post,
					"processToken"=>$res["processToken"],
				];

				// write session cache..
				$this->Packer->Session->write($this->formCache,$cache);

				// next confirm page..
				$this->redirect("@dbtable/confirm");
				return;

			}

		}
		else
		{

			// if no exist Request Data(POST) then...

			if($id){

				// get recode data...
				$res=$this->Model->Dbtable1->getData($id);

				if(!empty($res["flg"])){
					Request::$post=$res["result"];
				}
				else{
					$this->Packer->Session->write("dangerMsg","Editing stopped because no records were found.");
					$this->redirect("@dbtable");
					return;
				}
			}

			if(!empty(Request::$get["data_keep"])){
				$cache=$this->Packer->Session->read($this->formCache);
				Request::$post=$cache["post"];
			}


		}

	}

	# confirm 

	public function confirm(){

		$cache=$this->Packer->Session->read($this->formCache);
		if(!$cache){
			$this->redirect("@dbtable/edit");
		}

		$this->set("cache",$cache);

		if(Request::$post){
			$post=Request::$post;

			//verify check
			if(!$this->Packer->Form->verify()){
				echo "ERROR! : Processing was interrupted due to unauthorized access.";
				exit;
			}
			else
			{

				$res=$this->Model->Dbtable1->process($cache);

				$this->Packer->Session->delete($this->formCache);
				
				if(!empty($res["flg"])){
					$this->Packer->Session->write("sendMsg","Record update / registration completed");
				}
				else{
					$this->Packer->Session->write("dangerMsg","Record update / registration failed. <br>Error : ".$res["error"]);
				}
				$this->redirect("@dbtable");
				return;

			}
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