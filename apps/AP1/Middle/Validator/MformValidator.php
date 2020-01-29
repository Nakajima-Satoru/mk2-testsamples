<?php

namespace mk2\core;

class MformValidator extends Validator{

	public $v_step1=[
		"your_name"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"nameが未入力です",
			],
			"N2"=>[
				"rule"=>["maxLength",100],
				"message"=>"nameは100文字以内で入力してください",
			],
		],
		"email"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"emailが未入力です",
			],
			"N2"=>[
				"rule"=>["maxLength",255],
				"message"=>"emailは255文字以内で入力してください",
			],
			"N3"=>[
				"rule"=>"isEmail",
				"message"=>"メールフォーマット形式ではありません",
			],
		],
		"telno"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"telephone numberが未入力です",
			],
			"N2"=>[
				"rule"=>["maxLength",255],
				"message"=>"telephone numberは255文字以内で入力してください",
			],
			"N3"=>[
				"rule"=>"isTel",
				"message"=>"電話番号のフォーマット形式ではありません",
			],
		],
	];

	public $v_step2=[
		"free_textarea"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"free textareaが未入力です",
			],
			"N2"=>[
				"rule"=>["maxLength",4000],
				"message"=>"free textareaは4000文字以内で入力してください",
			],
		],
	];

	public $v_step3=[
		"category"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"categoryが未選択です",
			],
		],
	];

	public $v_step4=[
		"like_fruit"=>[
			"N1"=>[
				"rule"=>"notBlank",
				"message"=>"like fruitが未選択です",
			],
		],
	];
}