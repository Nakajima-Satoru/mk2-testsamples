<?php

namespace mk2\core;

return [
	"authName"=>"mk2authtest",
	"parityCode"=>[
		"algo"=>"sha512",
		"salt"=>"abcdefg10293jifpaijrafAOIFjeiar098faf1a56e4ag1af56a5g1as1a6f5a1w5gfjOFIJReafeafFIOFjiqwoe444545faIEOPffiheofr",
		"stretch"=>5,
	],
	"redirect"=>[
		"login"=>"@auth/login",
		"logined"=>"@auth",
	],
	"dbTable"=>[
		"table"=>"User",
		"username"=>"username",
		"password"=>"password",
		"addRule"=>[
			["delete_flg",0],
			["role",0],
		],
		"fields"=>["id","nickname","username","email"],
		"hash"=>[
			"algo"=>"sha512",
			"salt"=>"af4189efa4f4Ff9ae84fga19f8eafjfiaoeriDF15der2gHUffIFrfeOeIeEUeHeFeddgX8da9e8rfa0g9a8fafha8fheu2dega4iu3f1a95erf4af1a32f",
			"stretch"=>6,
		],
	],
];