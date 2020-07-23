<?php

namespace mk2\core;

class MformValidator extends Validator{

	public $v_step1=[
		"your_name"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"name is not entered",
			],
			"N2"=>[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"email"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"Email is not entered",
			],
			"N2"=>[
				"rule"=>["maxLength",255],
				"message"=>"Enter within 255 characters",
			],
			"N3"=>[
				"rule"=>"isEmail",
				"message"=>"Not in email format",
			],
		],
		"telno"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"Telephone Number is not entered",
			],
			"N2"=>[
				"rule"=>["maxLength",255],
				"message"=>"",
			],
			"N3"=>[
				"rule"=>"isTel",
				"message"=>"Not in Telephone Number format",
			],
		],
	];

	public $v_step2=[
		"free_textarea"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"free text area is not entered",
			],
			"N2"=>[
				"rule"=>["maxLength",4000],
				"message"=>"Enter within 4000 characters",
			],
		],
	];

	public $v_step3=[
		"category"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"category is not selected",
			],
		],
	];

	public $v_step4=[
		"like_fruit"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"like fruit is not selected",
			],
		],
	];
}