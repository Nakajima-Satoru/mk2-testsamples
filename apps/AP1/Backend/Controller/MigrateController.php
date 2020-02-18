<?php
namespace mk2\core;

Import::Controller("App");

class MigrateController extends AppController{

	public $autoRender=false;

	public function tabletest(){

		//setTable 
		$this->setTable(["Table1"]);

		// Table Class Direct
		$table2=new Table([
			"setSchema"=>[
				"type"=>"mysql",
				"host"=>"localhost",
				"port"=>3306,
				"username"=>"root",
				"password"=>"",
				"database"=>"rmk2test",
				"encoding"=>"utf8mb4",
			],
			"table"=>"account",
		]);

		// Orm Class Direct
		$table3=new \mk2\orm\Orm("account",[
			"type"=>"mysql",
			"host"=>"localhost",
			"port"=>3306,
			"username"=>"root",
			"password"=>"",
			"database"=>"rmk2test",
			"encoding"=>"utf8mb4",
		]);

		debug($this->Table->Table1->select()->all());
		debug($table2->select()->all());
		debug($table3->select()->all());
		debug(\mk2\orm\OrmDo::$PDO);

	}
	public function index(){

		$this->setTable(["Test"]);

		$migrate=$this->Table->Test->migrate();
		$migrate
			->makeSchema()
			->comment("== MIGRATION TEST SAMPLE =================================")
			->comment(" table01 create =================================")
			->create("table01",[
				"comment"=>"テーブル01",
			])
			->setField("id",[
				"type"=>"int",
				"length"=>11,
				"primaryKey"=>true,
				"comment"=>"ID",
			])
			->setField("created",[
				"type"=>"datetime",
				"notNull"=>true,
				"comment"=>"作成日",
			])
			->setField("midified",[
				"type"=>"datetime",
				"notNull"=>true,
				"comment"=>"更新日",
			])
			->setField("is_deleted",[
				"type"=>"int",
				"length"=>2,
				"default"=>0,
				"notNull"=>true,
				"comment"=>"削除フラグ",
			])
			->setField("name",[
				"type"=>"varchar",
				"length"=>255,
				"comment"=>"名前",
			])
			->setField("code",[
				"type"=>"varchar",
				"length"=>255,
				"comment"=>"コード",
			])
			->comment(" table02 create =================================")
			->create("table02",[
				"comment"=>"テーブル02",
			])
			->setField("id",[
				"type"=>"int",
				"length"=>11,
				"primaryKey"=>true,
				"comment"=>"ID",
			])
			->setField("created",[
				"type"=>"datetime",
				"notNull"=>true,
				"comment"=>"作成日",
			])
			->setField("midified",[
				"type"=>"datetime",
				"notNull"=>true,
				"comment"=>"更新日",
			])
			->setField("is_deleted",[
				"type"=>"int",
				"length"=>2,
				"default"=>0,
				"notNull"=>true,
				"comment"=>"削除フラグ",
			])
			->setField("your_name",[
				"type"=>"varchar",
				"length"=>255,
				"default"=>0,
				"notNull"=>true,
				"comment"=>"名前",
			])
		
			// Alter Table
			->alter("add","table02",[
				"name"=>"add_colums",
				"type"=>"varchar",
				"length"=>255,
				"comment"=>"追加カラム名",
			])
			->alter("add","table02",[
				"name"=>"add_colums2",
				"type"=>"int",
				"length"=>20,
				"comment"=>"追加カラム名2",
			])
			->alter("drop","table02",[
				"name"=>"your_name",
			])
		
			// ALTER TABLE(modify)
			->alter("modify","table02",[
				"name"=>"add_colums2",
				"type"=>"varchar",
				"length"=>255,
				"after"=>"id",
			]);

		try{
			debug($migrate->getSqlCode());
			debug($migrate->run());
		}catch(\Exception $e){

		}
		
	}

	public function sqlite_test(){

		$Table4=new Table([
			"setSchema"=>[
				"type"=>"sqlite",
				"database"=>"SQLITEDB.sqlite3",
			],
		]);

		$t4m=$Table4->migrate()->makeSchema()
			->create("table01",[
				"comment"=>"テーブル01",
			])
			->setField("id",[
				"type"=>"int",
				"length"=>11,
				"primaryKey"=>true,
				"autoIncrement"=>true,
				"comment"=>"ID",
			])
			->setField("created",[
				"type"=>"datetime",
				"comment"=>"ID",
			])
			->setField("modified",[
				"type"=>"datetime",
				"comment"=>"ID",
			])
			->setField("is_deleted",[
				"type"=>"integer",
				"default"=>0,
				"notNull"=>true,
				"comment"=>"ID",
			])
			->setField("name",[
				"type"=>"varchar",
			])
			->setField("code",[
				"type"=>"varchar",
			])
			->create("table02")
			->setField("id",[
				"type"=>"int",
				"length"=>11,
				"primaryKey"=>true,
				"autoIncrement"=>true,
				"comment"=>"ID",
			])
			->setField("created",[
				"type"=>"datetime",
				"comment"=>"ID",
			])
			->setField("modified",[
				"type"=>"datetime",
				"comment"=>"ID",
			])
			->setField("is_deleted",[
				"type"=>"integer",
				"default"=>0,
				"notNull"=>true,
				"comment"=>"ID",
			])
			->insert("table01",[
				"created"=>date_format(date_create("now"),"Y-m-d H:i:s"),
				"modified"=>date_format(date_create("now"),"Y-m-d H:i:s"),
				"name"=>"aaaa",
				"code"=>"a1234",
			])
			->insert("table01",[
				"created"=>date_format(date_create("now"),"Y-m-d H:i:s"),
				"modified"=>date_format(date_create("now"),"Y-m-d H:i:s"),
				"name"=>"bbbb",
				"code"=>"b2345",
			])
		;

		debug($t4m->getSqlCode());
		$t4m->run();

		$Table4->table="table01";
		debug($Table4->select()->all());

	}
}