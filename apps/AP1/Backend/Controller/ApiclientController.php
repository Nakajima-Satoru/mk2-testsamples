<?php

namespace mk2\core;

Import::Controller("App");

class ApiclientController extends AppController{

	public function __construct(){
		parent::__construct();

		$url="http://localhost".Request::$params["root"]."api_server/private";

		$this->setPacker([
			"Form"=>[
				"cssFramework"=>"bootstrap",
			],
			"PrivateApi"=>[
				"APITEST_PRIVATE"=>[
					"mode"=>"private",
					"url"=>$url,
					"token"=>[
						"algo"=>"sha512",
						"salt"=>"1A92f8g3g9aaaDerZfajirapigjadifjDOijrg43AdQ34ww",
						"stretch"=>6,
						"limit"=>25,
					],
					"header"=>[
						"aikotoba"=>"grips2",
					],
				],
			],
		]);

	}

	public function index(){

		if(Request::$get){
			$get=Request::$get;

			if(!empty($get["request"])){

				$this->autoRender=false;

				$res=$this->Packer->PrivateApi->access("APITEST_PRIVATE");
				debug($res);

			}
		}

	}
}