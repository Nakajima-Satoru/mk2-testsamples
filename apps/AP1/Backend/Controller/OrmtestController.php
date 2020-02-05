<?php

/**
 * OrmtestController
 * 
 * Backend/Controller/OrmtestController.php
 * 
 * Top page or other screen controller.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace mk2\core;

Import::Controller("App");

class OrmtestController extends AppController{

	public function __construct(){
		parent::__construct();

		$this->setTable([
			"Table1",
			"Table1a",
		]);

	}

	# Top page
	public function index(){}

	# select test
	public function select1(){

		$this->set("sample_1",$this->Table->Table1->select()->all());
		$this->set("sample_2",$this->Table->Table1->select()->first());
		$this->set("sample_3",$this->Table->Table1->select()->lists());
		$this->set("sample_4",$this->Table->Table1->select()->count());
		$this->set("sample_5",$this->Table->Table1->select()->sqlCode());

		$sample_6=$this->Table->Table1->select()
			->where("id >",4)
			->all();
		$this->set("sample_6",$sample_6);

		$sample_7=$this->Table->Table1->select()
			->where("id >",4)
			->where("id <",6)
			->all();
		$this->set("sample_7",$sample_7);

		$sample_8=$this->Table->Table1->select()
			->where("NOT id ",3)
			->sqlCode();
		$this->set("sample_8",$sample_8);

		$sample_9=$this->Table->Table1->select()
			->where("NOT code","item04")
			->all();
		$this->set("sample_9",$sample_9);

		$sample_10=$this->Table->Table1->select()
			->where("id",[3,5,7])
			->all();
		$this->set("sample_10",$sample_10);

		$sample_11=$this->Table->Table1->select()
			->where("id",3)
			->where("id",4,"OR")
			->all();
		$this->set("sample_11",$sample_11);

		$sample_12=$this->Table->Table1->select()
			->where("code LIKE","04")
			->all();
		$this->set("sample_12",$sample_12);

		$sample_13=$this->Table->Table1->select()
			->fields(["id","created","name","code"])
			->all();
		$this->set("sample_13",$sample_13);

		$sample_14=$this->Table->Table1->select()
			->fields(["table_id"=>"id","create_date"=>"created","your_name"=>"name","number"=>"code"])
			->all();
		$this->set("sample_14",$sample_14);

		$sample_15=$this->Table->Table1->select()
			->where("id",3)
			->fields(["table_id"=>"id","create_date"=>"created","your_name"=>"name","number"=>"code"])
			->all();
		$this->set("sample_15",$sample_15);


	}
	# select test
	public function select2(){

		$sample_1=$this->Table->Table1->select()
			->fields(["code","name"])
			->lists();
		$this->set("sample_1",$sample_1);

		$sample_2=$this->Table->Table1->select()
			->orderBy("id","desc")
			->all();
		$this->set("sample_2",$sample_2);

		$sample_3=$this->Table->Table1->select()
			->limit(3)
			->all();
		$this->set("sample_3",$sample_3);

		$sample_4=$this->Table->Table1->select()
			->limit(3)
			->pageIndex(2)
			->all();
		$this->set("sample_4",$sample_4);
	
		$sample_5=$this->Table->Table1->select()
			->paginate(3,2)
			->all();
		$this->set("sample_5",$sample_5);
		
	}

	public function select3(){

		$sample_1=$this->Table->Table1
		->associate([
			"hasMany"=>[
				"Table1a",
			],
		])
		->select()
		->all();
		$this->set("sample_1",$sample_1);

		$this->Table->Table1->associate();

		$sample_2=$this->Table->Table1
		->hasMany([
			"Table1a"=>[
				"fields"=>["table1_id","subname"],
			],
		])
		->select()
		->all();
		$this->set("sample_2",$sample_2);

		$this->Table->Table1->associate();

		$sample_3=$this->Table->Table1
		->associate([
			"hasOne"=>[
				"Table1a",
			],
		])
		->select()
		->all();
		$this->set("sample_3",$sample_3);

		$this->Table->Table1->associate();

		$sample_4=$this->Table->Table1
		->hasOne([
			"Table1a"=>[
				"fields"=>["table1_id","subname"],
			],
		])
		->select()
		->all();
		$this->set("sample_4",$sample_4);

		$sample_5=$this->Table->Table1a
		->associate([
			"belongsTo"=>[
				"Table1",
			],
		])
		->select()
		->all();
		$this->set("sample_5",$sample_5);

		$sample_6=$this->Table->Table1a
		->belongsTo([
			"Table1"=>[
				"fields"=>["id","name"],
			],
		])
		->select()
		->all();
		$this->set("sample_6",$sample_6);
	}

	public function save1(){


		
	}

	public function test1(){
		$this->autoRender=false;

		$this->setTable(["New"]);
		debug($this->Table->New);
		
		debug($this->Table->New->select()->all());
	}
	public function test2(){
		$this->autoRender=false;
/*
		$checkTable=new Table([
			"setSchema"=>[
				"type"=>"mysql",
				"host"=>"localhost",
				"port"=>3306,
				"username"=>"root",
				"password"=>"",
			],
		]);

		debug($checkTable->connectCheck());
*/
		/*
		$this->setTable(["New"]);
		debug($this->Table->New->connectCheck());
		*/
/*
		$this->setTable(["Table1a"]);
		debug($this->Table->Table1a->connectCheck());
*/
	}
}