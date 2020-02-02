<?php
namespace mk2\core;

Import::Controller("App");

class MigrateController extends AppController{

    public function index(){
        $this->autoRender=false;

        $this->setTable(["Test"]);

        $migrate=$this->Table->Test->migrate();
        $migrate
        ->makeSchema()
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
            ]);
        debug($migrate->getSqlCode());
    }
}