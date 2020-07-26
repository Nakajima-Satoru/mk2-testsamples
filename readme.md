# Test Sample(Account Authentication)

Test sample for account authentication.

# Main adjustment points

## 1. Database preparation

When you first press the "Auth Login" button on the TOP page and the following message is displayed,   
it means that the database server does not exist or the database tables have not been prepared.

```
Database Access Error

It doesn't seem to connect to the database or the database table doesn't exist.
Review the settings of the database connection destination, download the SQL code from the following, and import it to any database server.
```

In this case, it is considered that the database connection settings are incorrect (database connection destination does not exist, etc.)   
or the dedicated database is not installed on the database server.

First, check the database connection destination.
The database connection destination is the following by default.  
Please change to a location where you can connect.

```php
"default"=>[
	"type"=>"mysql",
	"host"=>"localhost",
	"username"=>"root",
	"password"=>"",
	"port"=>3306,
	"database"=>"mk2dbauth",
	"encoding"=>"utf8mb4",
],
```

After confirming that it is connected to the database connection destination, if the database (schema) does not exist, import the SQL data.

For SQL data, there is a SQL file in the following path, so import that.

---

## 2.  Change routing content

Make sure the routes for pages in ``/apps/AP1/AppConf/routing.php`` are as follows.

```php
"pages"=>[
	"/"=>"main@index",
	"/auth"=>"auth@index",
	"/auth/login"=>"auth@login",
	"/auth/create"=>"auth@create",
	"/auth/logout"=>"auth@logout",
],
```

## 3. Code description of AuthController

Open the ``AuthController.php`` file in the ``apps/AP1/Backend/Controller`` directory and make sure the code looks like this:

### # constructor

Make sure the constructor is set as shown below.

SampleAuthPacker is a wrapper class of AuthPacker. This will be described later.

```php
public function __construct(){
	parent::__construct();

	$this->setPacker([
		"Form"=>[
			"cssFramework"=>"bootstrap",
		],
		"Session",
		"SampleAuth",
	])
	->setTable([
		"User",
	])
	->setValidator([
		"Auth",
	]);

	// List of URLs that can be accessed without authentication authority
	$this->Packer->SampleAuth->allowList=[
		"@auth/create",
	];

	// login Check...
	$this->Packer->SampleAuth->loginCheck();

	// send message loading
	if($this->Packer->Session->read("sendMsg")){
		$this->set("sendMsg",$this->Packer->Session->flash("sendMsg"));
	}

}
```

### # index(action)

Set up a screen (action) that can be accessed after logging in.  
It is an index action.

```php
public function index(){
	$this->set("authData",$this->Packer->SampleAuth->getAuthData());
}
```

### # login(action)

Set up a login screen action.

The sample pre-checks whether the database table already exists.  
It is a specification that displays a dedicated message when the database table does not exist.

```php
public function login(){

	// For checking if the database can be connected....
	try{
		$this->Table->User->select()->count();
	}catch(\Exception $e){
		$this->render="noDbtable";
		return;
	}

	if(Request::$post){

		// verify check
		if(!$this->Packer->Form->verify()){
			echo "Error! : The process was interrupted because it was determined to be unauthorized access.";
			exit;
		}

		$post=Request::$post;
			
		// validate
		$validate=$this->Validator->Auth->verify($post);

		if($validate){
			$this->PackerUI->Form->setErrors($validate);
		}
		else{

			if($this->Packer->SampleAuth->login($post)){
				$this->redirect("@auth/");
			}
			else{
				$this->Packer->Form->setErrors([
					"username"=>"I cannot log in because my account information does not exist or I do not have permission",
				]);
			}

		}
	}
}
```

### # create(action)

Set up a screen (action) for creating a user account.

Since the default account is not included in the sample SQL data, create an account here and then try logging in.  
This can also be used for new member registration.

```php
public function create(){

	if(Request::$post){

		// verify check
		if(!$this->Packer->Form->verify()){
			echo "Error! : The process was interrupted because it was determined to be unauthorized access.";
			exit;
		}

		$post=Request::$post;

		// validate
		$validate=$this->Validator->Auth->verify($post,"validate_created");

		if($validate){
			$this->PackerUI->Form->setErrors($validate);
		}
		else{

			// user table create

			try{

				$saveObj=$this->Table->User->save()->tsBegin();

				$saves=[
					"username"=>$post["username"],
					"password"=>$this->Packer->SampleAuth->getPasswordHash($post["password"]),
					"nickname"=>$post["nickname"],
					"email"=>$post["email"],
					"role"=>10,
				];

				$res=$saveObj->save($saves);

			}catch(\Exception $e){
				$saveObj->tsRollback();
				echo $e;
				exit;
			}

			$saveObj->tsCommit();
				
			// send message setting
			$this->Packer->Session->write("sendMsg","Account registration completed");

			return $this->redirect("@auth/login/");

		}
	}
}
```

### # logout(action)

Set up an action for logout.

```php
public function logout(){
	$this->autoRender=false;
		
	// logout
	$this->Packer->SampleAuth->logout();

	return $this->redirect("@auth/login/");

}
```

## 4. Installation of SampleAuthPacker

AuthPacker which is an extension Packer is used as a class for account authentication.

AuthPacker can be used as it is, but it is necessary to prevent unauthorized use of the account by changing the database table or column to be authenticated and changing the password hash generation algorithm and parity code hash generation algorithm.

Therefore, create a new SampleAuthPacker that inherits AuthPacker and specify the setting information such as hash salt and stretch value there.

The location is ``apps/AP1/Backend/Packer/SampleAuthPacker.php``.

```php
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
```

---

## 5. Installation of UserTable and AuthValidator

Set UserTable class as a class for database table connection.  
Place it in ``apps/AP1/Middle/Table/UserTable.php``.

```php
<?php

namespace mk2\core;

class UserTable extends Table{

	public $timeStamp=[
		"created_at"=>"created",
		"updated_at"=>"updated",
	];
	
}
```

Next, install AuthValidator class which is a class for validation of input data.  
The location is ``apps/AP1/Middle/Validator/AuthValidator.php``.

Describe each validation rule at the time of login ($validate) and account registration ($validate_created) in the code.

```php
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
```

## 5. Rendering

Each page has a view file in the ``apps/AP1/Rendering/Render`` directory.

---

HP : https://www.mk2-php.com/  
Copylight (C) Nakajima Satoru.