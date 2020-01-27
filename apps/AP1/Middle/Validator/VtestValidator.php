<?php

namespace mk2\core;

class VtestValidator extends Validator{

	public $validate=[
		"name"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"name is not entered."
			],
			"N2"=>[
				"rule"=>["maxLength",100],
				"message"=>"Enter the name within 100 characters."
			],
		],
		"email"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"Email is not entered."
			],
			"N2"=>[
				"rule"=>"isEmail",
				"message"=>"Not in email format."
			],
			"N3"=>[
				"rule"=>["maxLength",255],
				"message"=>"Enter the Email within 255 characters."
			],
		],
		"telno"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"telephone number is not entered."
			],
			"N2"=>[
				"rule"=>"isTel",
				"message"=>"Not in telephone number format."
			],
			"N3"=>[
				"rule"=>["maxLength",20],
				"message"=>"Enter the telephone number within 20 characters."
			],
		],
		"category"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"Category is not entered."
			],
		],
		"hpurl"=>[
			"N1"=>[
				"rule"=>"isUrl",
				"message"=>"Not in Homepage URL format."
			],
			"N2"=>[
				"rule"=>["maxLength",255],
				"message"=>"Enter the Homepage URL within 255 characters."
			],
		],
		"message"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"Not in message URL format."
			],
			"N2"=>[
				"rule"=>["maxLength",4000],
				"message"=>"Enter the message URL within 4000 characters."
			],
		],
	];

}