<?php

namespace mk2\core;

class AuthValidator extends Validator{

	public $validate=[
		"username"=>[
			[
				"rule"=>"notBlank",
				"message"=>"ユーザー名が入力されていません",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>"ユーザー名は下記の記号と半角英数字のみで入力してください<br>「-」「_」「=」「@」「+」「.」「,」",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"ユーザー名は100文字以内で入力してください",
			],
		],
		"password"=>[
			[
				"rule"=>"notBlank",
				"message"=>"パスワードが入力されていません",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>"パスワードは下記の記号と半角英数字のみで入力してください<br>「-」「_」「=」「@」「+」「.」「,」",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"パスワードは100文字以内で入力してください",
			],
		],
	];

	public $validate_created=[
		"username"=>[
			[
				"rule"=>"notBlank",
				"message"=>"ユーザー名が入力されていません",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>"ユーザー名は下記の記号と半角英数字のみで入力してください<br>「-」「_」「=」「@」「+」「.」「,」",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"ユーザー名は100文字以内で入力してください",
			],
		],
		"password"=>[
			[
				"rule"=>"notBlank",
				"message"=>"パスワードが入力されていません",
			],
			[
				"rule"=>["alphaNumeric","-_=@+.,"],
				"message"=>"パスワードは下記の記号と半角英数字のみで入力してください<br>「-」「_」「=」「@」「+」「.」「,」",
			],
			[
				"rule"=>["maxLength",100],
				"message"=>"パスワードは100文字以内で入力してください",
			],
		],
		"nickname"=>[
			[
				"rule"=>"notBlank",
				"message"=>"ニックネームが入力されていません",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"ニックネームは255文字以内で入力してください",
			],
		],
		"email"=>[
			[
				"rule"=>"notBlank",
				"message"=>"Emailが入力されていません",
			],
			[
				"rule"=>"isEmail",
				"message"=>"不正なメールフォーマット形式と判断致しました",
			],
			[
				"rule"=>["maxLength",255],
				"message"=>"Emailは255文字以内で入力してください",
			],
		]
	];

	
	
}