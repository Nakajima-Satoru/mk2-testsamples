# Test Sample(Form Test)

It is a sample sample of the inquiry form with the transition function to the confirmation screen.

Display logic of Form tag, input data verification check, and transition to confirmation screen are built.  
Please adjust the actual e-mail notification and data storage etc.

# Main adjustment points

## 1. set routing

Set the routing in the ``/apps/AP1/AppConf/routing.php`` file.

```php
<?php

return [

	/**
	 * pages
	 * 
	 * Click here for routing on each page (end point).
	 */

	"pages"=>[
		"/"=>"main@index",
		"/form"=>"form@index",
		"/form/confirm"=>"form@confirm",
		"/form/complete"=>"form@complete",
	],

	/**
	 * error
	 * 
	 * Click here for routing after error judgment.
	 */

	"error"=>[
		500=>"error@page500",
		404=>"error@page404",
	],

];
```

<hr>

## 2. FormController settings

Set the code in FormController.  
Check the following contents.

### #. constructor

The constructor is as follows.

```php
public function __construct(){

	parent::__construct();

	$this->setPacker([
		"Session",
		"Form"=>[
			"cssFramework"=>"bootstrap",
		],
	])
	->setModel([
		"Form1",
	]);

}
```

Packer uses Extended Packer Session and Form.  
(Form's cssFramework uses bootstrap as the css framework, so configure it)

Since the confirmation screen is sandwiched this time, use Session to temporarily store the input data.

Model class creates a new Form1 and loads it.  

### #. Setting the index action

Set the index action (public method).

```php
# index
public function index(){

	# Get list of categories and set to View
	$this->set("categoryList",$this->Model->Form1->getCategoryList());

	if(Request::$post){

		# token verify...
		if(!$this->Packer->Form->verify()){
			echo "ERROR! : Request Access Error";
			exit;
		}

		$post=Request::$post;

		# post data validation
		$res=$this->Model->Form1->validate($post);
			
		if(!empty($res["validate"])){

			# If there is a validation error, return the result in Form tag.
			$this->PackerUI->Form->setErrors($res["validate"]);

		}
		else
		{

			# Keep post data in Session temporarily
			$this->Packer->Session->write($this::FORM_SESSION_CACHE,[
				"post"=>$post,
				"processToken"=>$res["processToken"],
			]);

			# Redirect to confirmation screen
			$this->redirect("@form/confirm");

		}
	}
	else{

		# Acquire the temporarily saved post data in Session data
		$cache=$this->Packer->Session->read($this::FORM_SESSION_CACHE);

		# If there is data held in Session, it is reflected in Form tag.
		if(!empty($cache["post"])){
			Request::$post=$cache["post"];
		}

	}

}
```

### # Setting confirm action

Next, set a confirm action (public method) for the confirmation screen.

```php
# confirm
	
public function confirm(){

	# Check temporarily saved data in Session data
	$cache=$this->Packer->Session->read($this::FORM_SESSION_CACHE);

	if(empty($cache["post"])){

		# If there is no temporarily saved data, it is forced to redirect to the form screen.
		$this->redirect("@form");

	}

	# Set temporarily saved data to View
	$this->set("cache",$cache["post"]);

	# set categoryList
	$this->set("categoryList",$this->Model->Form1->getCategoryList());

	if(Request::$post){

		# post requested...

		# token verify...
		if(!$this->Packer->Form->verify()){
			echo "ERROR! : Request Access Error";
			exit;
		}

		$post=Request::$post;

		# process....
		$res=$this->Model->Form1->process($cache);

		# ckear cache...
		$this->Packer->Session->delete($this::FORM_SESSION_CACHE);

		if($res){
			# successed.
			$this->redirect("@form/complete");
		}
		else
		{
			# failed.
			echo "ERROR! : The procedure failed.";
			exit;
		}
	}
}
```
## 3. Preparing the Form1Model class

Place Form1Model.php in the ``/apps/AP1/Middle/Model`` directory.  

Make sure that the following codes are installed.

### #. Setting salt constants for process_token

The salt for generating process_token for permission check to execute the process method which is the actual procedure method is made constant.  

```php
private const PROCESS_TOKEN_SALT="f0a9riegjiapfiaoje09f0f0fajiopfAOfij4i4rF93049fjIOFApor098g7094095";
```

### #. Constructor

In the constructor, load the Form1Validator class.

```php
public function __construct(){
	parent::__construct();

	$this->setValidator([
		"Form1",
	]);

}
```

### #. validate method

Set validate method for input data validation.

```php
public function validate($post){

	$validate=$this->Validator->Form1->verify($post);

	if($validate){
		return [
			"flg"=>false,
			"validate"=>$validate,
		];
	}
	else
	{
		return [
			"flg"=>true,
			"processToken"=>$this->getProcessToken($post),
		];
	}
}
```

### #. process method

Set process method which is the method for actual procedure processing.  
In order to prevent this method from being executed illegally, authentication check by process_token is inserted in advance.

If you want to implement functions such as email notification and record registration after passing the authentication check, please code as you like.  
In the sample, only comment out is described.

```php
public function process($post){

	# process Token Check...
	if(!$this->processTokenCheck($post)){
		return false;
	}

	/**
	 * 
	 * 
	 * 
	 * Describe the procedure processing content here....
	 * 
	 * 
	 * 
	 */

	return true;

}
```

## 4. Preparing Validator

Prepare Form1Validator for validation check of input data.
Check the Form1Validator.php file in the ``/apps/AP1/Middle/Validator`` directory.

Set the validation rule and display message for each input item in public variable $validate.

```php
<?php

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
```

## 5. View Setting

Create a ``Form1`` directory in the ``/apps/AP1/Rendering/Render`` directory and prepare a view file for each screen (action).

3 files of index.view, confirm.view, complete.view are the views of each action.


```
```

<hr>

HP : https://www.mk2-php.com/  
Copylight (C) Nakajima Satoru.