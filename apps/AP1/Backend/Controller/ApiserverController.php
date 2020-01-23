<?php

namespace mk2\core;

class ApiserverController extends Controller{

	public $autoRender=false;

	public function __construct(){
		parent::__construct();

		$this->setPacker([
			"PrivateApi"=>[
				"APITEST_PRIVATE"=>[
					"mode"=>"private",
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

	# private

	public function private(){

		if(!$this->Packer->PrivateApi->listen("APITEST_PRIVATE")){
			http_response_code(400);
			return json_encode(["error"=>"Authentication failed"]);
		}
		else
		{
			return json_encode(["flg"=>"ok"]);
		}

	}
}