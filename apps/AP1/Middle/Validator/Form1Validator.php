<?php

/**
 * Form1Validator
 */

namespace mk2\core;

class Form1Validator extends Validator{


	public $validate=[
		"your_name"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No name entered",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"your_name_kana"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No name(kana) entered",
			],
			[
				"rule"=>"isKatakana",
				"message"=>"Enter only full-width katakana and full-width/half-width spaces",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"email"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No Email entered",
			],
			[
				"rule"=>"isEmail",
				"message"=>"Judged as an invalid email format",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"Enter within 255 characters",
			],
		],
		"telno"=>[
			[
				"rule"=>"notBlank",
				"message"=>"No TEL entered",
			],
			[
				"rule"=>"isTel",
				"message"=>"Judged as invalid TEL format",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"Enter within 100 characters",
			],
		],
		"hpurl"=>[
			[
				"rule"=>"isUrl",
				"message"=>"Judged as an invalid URL format",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"Enter within 255 characters",
			],
		],
		"category"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Category not selected",
			],
		],
		"message"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Message content has not been entered",
			],
			[
				"rule"=>["maxLength",5000],
				"message"=>"Enter within 5000 characters",
			],
		],
	];

}