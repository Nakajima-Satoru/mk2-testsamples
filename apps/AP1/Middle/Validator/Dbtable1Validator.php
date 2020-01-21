<?php

namespace mk2\core;

class Dbtable1Validator extends Validator{

	public $validate=[
		"name"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"name is not entered",
			],
			"N2"=>[
				"rule"=>["maxLength",255],
				"message"=>"Enter the name within 255 characters",
			],
		],
		"code"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"code is not entered",
			],
			"N2"=>[
				"rule"=>"alphaNumeric",
				"message"=>"code must be alphanumeric",
			],
			"N3"=>[
				"rule"=>["maxLength",100],
				"message"=>"Enter the code within 100 characters",
			],
		],
		"caption"=>[
			"N2"=>[
				"rule"=>["maxLength",3000],
				"message"=>"caption can be up to 3000 characters",
			],
		],
	];

}