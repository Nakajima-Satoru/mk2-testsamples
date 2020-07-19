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

## 3. View Setting

Create a ``Form1`` directory in the ``/apps/AP1/Rendering/Render`` directory and prepare a view file for each screen (action).

<hr>

HP : https://www.mk2-php.com/  
Copylight (C) Nakajima Satoru.