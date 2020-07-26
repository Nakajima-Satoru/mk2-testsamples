<?php

namespace mk2\core;

class AuthValidator extends Validator{

	public $validate=[
		"username"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Username not entered",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>'Enter the user name using the following symbols and single-byte alphanumeric characters only.<br>"-","_","=","@","+",".",","',
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"password"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No password entered",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>'Enter the user name using the following symbols and single-byte alphanumeric characters only.<br>"-","_","=","@","+",".",","',
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
	];

	public $validate_created=[
		"username"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Username not entered",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>'Enter the user name using the following symbols and single-byte alphanumeric characters only.<br>"-","_","=","@","+",".",","',
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"password"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No password entered",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>'Enter the user name using the following symbols and single-byte alphanumeric characters only.<br>"-","_","=","@","+",".",","',
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"nickname"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No nickname entered",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"Enter within 255 characters",
			],
		],
		"email"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Email not entered",
			],
			[
				"rule"=>"isEmail",
				"message"=>"Judged as an invalid mail format",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"Enter within 255 characters",
			],
		]
	];

	
	
}