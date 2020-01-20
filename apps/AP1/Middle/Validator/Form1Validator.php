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
				"message"=>"お名前が入力されていません",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"お名前は100文字以内で入力してください",
			],
		],
		"your_name_kana"=>[
			[
				"rule"=>"notBlank",
				"message"=>"お名前(フリガナ)が入力されていません",
			],
			[
				"rule"=>"isKatakana",
				"message"=>"お名前(フリガナ)は全角カタカナと全角空白・半角空白のみで入力してください",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"お名前(フリガナ)は100文字以内で入力してください",
			],
		],
		"email"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Emailが入力されていません",
			],
			[
				"rule"=>"isEmail",
				"message"=>"不正なEmailフォーマット形式と判断されました",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"Emailは255文字以内で入力してください",
			],
		],
		"telno"=>[
			[
				"rule"=>"notBlank",
				"message"=>"TELが入力されていません",
			],
			[
				"rule"=>"isTel",
				"message"=>"不正なTELフォーマット形式と判断されました",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"TELは100文字以内で入力してください",
			],
		],
		"hpurl"=>[
			[
				"rule"=>"isUrl",
				"message"=>"不正なURL形式と判断されました",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"HP URLは255文字以内で入力してください",
			],
		],
		"category"=>[
			[
				"rule"=>"notBlank",
				"message"=>"カテゴリーが選択されていません",
			],
		],
		"message"=>[
			[
				"rule"=>"notBlank",
				"message"=>"メッセージ内容が入力されていません",
			],
			[
				"rule"=>["maxLength",3000],
				"message"=>"メッセージ内容は3000文字以内で入力してください",
			],
		],
	];

}