<?php

namespace mk2\core;

Import::Packer("Auth");

class SampleAuthPacker extends AuthPacker{

	// auth name
	public $authName="mk2sampleauth";

	// parity code
	public $parityCode=[
		"algo"=>"sha256",
		"salt"=>"S9aa489q8er4f8f1C9ea8r4FIEoq1r56af47g1",
		"stretch"=>7,
	];
	
	// redirect url
	public $redirect=[
		"login"=>"@auth/login/",
		"logined"=>"@auth/",
	];
	
	// Database Table Setting
	public $dbTable=[
		"table"=>"User",
		"username"=>"username",
		"password"=>"password",
		"addRule"=>[
			["role >",10],
		],
		"fields"=>["id","username","email","nickname","role"],
		"hash"=>[
			"algo"=>"sha256",
			"salt"=>"JQAIERO490498560fajio4058590FJIOEER098505986",
			"stretch"=>9,
		],
	];

}