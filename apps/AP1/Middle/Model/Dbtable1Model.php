<?php

namespace mk2\core;

class Dbtable1Model extends Model{

	private $tokenSalt="Az3eeedg4fa89r7ga48r9af45g6a9r8e4ga654ra98re141faA59ra8FIEOGie09f";

	public function __construct(){
		parent::__construct();

		$this->setTable([
			"Dbtable1",
		])
		->setValidator([
			"Dbtable1",
		]);

	}

	# search

	public function search($query=null){

		$limit=5;
		$page=1;

		if($query){

			if(!empty($query["limit"])){
				$limit=$query["limit"];
			}

			if(!empty($query["page"])){
				$page=$query["page"];
			}

		}
	
		try{

			$res=$this->Table->Dbtable1->select([
				"type"=>"all",
				"where"=>[
					["delete_flg",0],
				],
				"paginate"=>[$limit,$page],
			]);

			return [
				"flg"=>true,
				"result"=>$res->result,
				"paginate"=>$res->paginate,
			];
		}
		catch(\Exception $e){
			return ["error"=>$e];
		}

	}

	# getData

	public function getData($id){

		# exist check
		$existCheck=$this->Table->Dbtable1->select([
			"type"=>"first",
			"where"=>[
				["delete_flg",0],
				["id",$id],
			],
		]);

		if(!$existCheck){
			return false;
		}

		try{

			$res=$this->Table->Dbtable1->select([
				"type"=>"first",
				"where"=>[
					["id",$id],
					["delete_flg",0],
				],
			]);

			if($res){
				return [
					"flg"=>true,
					"result"=>$res,
				];
			}
			else{
				return false;				
			}

		}
		catch(\Exception $e){
			return ["error"=>$e];
		}

	}

	# validate

	public function validate($post){

		$juge=$this->Validator->Dbtable1->verify($post);

		if($juge){
			return [
				"error"=>true,
				"validate"=>$juge,
			];
		}
		else
		{
			return [
				"flg"=>true,
				"processToken"=>$this->setProcessToken($post),
			];
		}

	}

	# process

	public function process($cache){

		# processToken exist check
		if(empty($cache["processToken"])){
			return [
				"error"=>"not found processToken",
			];
		}

		# processToken verify check
		if($cache["processToken"]!=$this->setProcessToken($cache["post"])){
			return [
				"error"=>"un matche processToken",
			];
		}

		try{

			$tableObj=$this->Table->Dbtable1->save()->tsBegin();

			$entity=[
				"name"=>$cache["post"]["name"],
				"code"=>$cache["post"]["code"],
				"caption"=>$cache["post"]["caption"],
			];

			if(!empty($cache["post"]["id"])){
				$entity["id"]=$cache["post"]["id"];
			}

			$res=$tableObj->save($entity);

		}catch(\Exception $e){
			$tableObj->tsRollback();
			return [
				"error"=>$e,
			];
		}

		$tableObj->tsCommit();

		return [
			"flg"=>true,
		];

	}

	# delete

	public function delete($id){

		# existCheck
		$existCheck=$this->getData($id);

		if(!$existCheck){
			return false;
		}

		try{

			$tableObj=$this->Table->Dbtable1->save()->tsBegin();

			$entity=[
				"id"=>$id,
				"delete_flg"=>1,
			];

			$tableObj->save($entity);
			
		}catch(\Exception $e){
			$tableObj->tsRollback();
			return[
				"error"=>$e,
			];
		}

		$tableObj->tsCommit();

		return [
			"flg"=>true,
		];

	}

	# setProcessToken

	private function setProcessToken($post){
		return hash("sha256",$this->tokenSalt.jsonEnc($post));
	}

}