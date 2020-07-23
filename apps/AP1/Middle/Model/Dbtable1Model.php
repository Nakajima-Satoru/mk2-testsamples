<?php

namespace mk2\core;

class Dbtable1Model extends Model{

	public function __construct(){
		parent::__construct();

		$this->setTable([
			"Dbtable1",
		])
		->setValidator([
			"Dbtable1",
		]);

	}

	# get

	public function get($id=null,$query=null){

		try{

			if($id){

				// get recode detail
		
				$res=$this->Table->Dbtable1->select([
					"type"=>"first",
					"where"=>[
						["id",$id],
						["delete_flg",0],
					],
				]);

				return $res;

			}
			else
			{
				// get recode list

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
				
				$res=$this->Table->Dbtable1->select([
					"type"=>"all",
					"where"=>[
						["delete_flg",0],
					],
					"paginate"=>[$limit,$page],
				]);

				return $res;
		
			}

		}catch(\Exception $e){
			return false;
		}
	}

	# validate

	public function validate($post){

		$juge=$this->Validator->Dbtable1->verify($post);
		return $juge;
		
	}

	# process

	public function process($cache){

		try{

			$tableObj=$this->Table->Dbtable1->save()->tsBegin();

			$entity=[
				"id"=>$cache["id"],
				"name"=>$cache["name"],
				"code"=>$cache["code"],
				"caption"=>$cache["caption"],
			];

			// save
			$res=$tableObj->save($entity);

			$tableObj->tsCommit();

			return [
				"flg"=>true,
			];
		
		}catch(\Exception $e){
			$tableObj->tsRollback();
			return [
				"flg"=>false,
				"error"=>$e,
			];
		}

	}

	# delete

	public function delete($id){

		# existCheck
		$existCheck=$this->get($id);

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

}