# Test Sample(Multiple Page Form)

This is a test sample of a procedure form consisting of multiple pages.

It can be used for input procedures that combine multiple pages such as for order flow and new member registration.

# Main adjustment points

## 1. Structure

Input data for each page is stored in Session.  
The retained data is also stored in the Session for each page and temporarily stored, so it is also used for authentication for each page.

---

## 2. Change routing content

Make sure the routes for pages in ``/apps/AP1/AppConf/routing.php`` are as follows.

```php
"pages"=>[
	"/"=>"main@index",
	"/mform/step1"=>"mform@step1",
	"/mform/step2"=>"mform@step2",
	"/mform/step3"=>"mform@step3",
	"/mform/step4"=>"mform@step4",
	"/mform/confirm"=>"mform@confirm",
	"/mform/complete"=>"mform@complete",
],
```

---

## 3. Code description of MformController

Open the ``MformController.php`` file in the ``apps/AP1/Backend/Controller`` directory and make sure the code looks like this:

### # constant

Set the constant used in Controller.

The constant MFORM_CACHE is the storage location of the input data Session.  
The constant AUTHORITY_ERROR_MESSAGE is the error message displayed when checking (CSRF check) when invalid input data is received.

```php
const MFORM_CACHE="__mform_cache__";
const AUTHORITY_ERROR_MESSAGE="The process was interrupted, judging that it was an unauthorized access.";
```

### # constructor

Make sure the constructor is set as shown below.

```php
public function __construct(){
	parent::__construct();

	$this->setPacker([
		"Form"=>[
			"cssFramework"=>"bootstrap",
		],
		"Session",
	])
	->setValidator([
		"Mform",
	]);

}
```

I will explain step by step.

Packer class uses FormPacker for generating Form tag, SessionPacker for managing Session data.  
Since the sample uses bootstrap as the CSS framework, I'll make it explicit in FormPacker.

### # Cache Verify Method

Set the method (_verify) to check the input data temporarily saved in Session as a private method.

Since the Session data is stored in the constant MFORM_CACHE, whether the data exists  
If it exists, it depends on whether it has been temporarily saved for each input data.  
Determine the behavior of the page

This method is always executed first on each page.

```php
private function _verify($checkTokenName=[]){

	$cache=$this->Packer->Session->read(self::MFORM_CACHE);

	if($cache){
			
		if($checkTokenName){

			$juge=true;

			// data exist check
			foreach($checkTokenName as $ctn_){
				if(empty($cache[$ctn_])){
					$juge=false;
				}
			}

			if($juge){
				return $cache;
			}
			else
			{
				if(Request::$params["action"]!="step1"){
					$this->redirect("@mform/step1/");
				}
			}
		}
		else
		{
			return $cache;
		}
	}
	else
	{
		if(Request::$params["action"]!="step1"){
			$this->redirect("@mform/step1");
		}
	}

}
```

### # Step1(action)

step1 is the first input screen.  
Check if the code is written as below.

```php
public function step1(){

	// cache data check
	$cache=$this->_verify();

	if(Request::$post){

		// token check
		if(!$this->Packer->Form->verify()){
			echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
			exit;
		}

		$post=Request::$post;

		// validate check
		$vres=$this->Validator->Mform->verify($post,"v_step1");

		if($vres){
			$this->PackerUI->Form->setErrors($vres);
		}
		else
		{
			$cache["step1"]=$post;
			$this->Packer->Session->write(self::MFORM_CACHE,$cache);
			$this->redirect("@mform/step2/");
		}

	}
	else{

		if(!empty(Request::$get["data_keep"])){
			if(!empty($cache["step1"])){
				Request::$post=$cache["step1"];
			}
		}

	}

}
```


### # Step2(action)

The input screen displayed next to the Step1 page is Step2.  
Check if the code is written as below.

```php
public function step2(){

	$cache=$this->_verify([
		"step1",
	]);

	if(Request::$post){

		// token check
		if(!$this->Packer->Form->verify()){
			echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
			exit;
		}

		$post=Request::$post;

		// validate check
		$vres=$this->Validator->Mform->verify($post,"v_step2");

		if($vres){
			$this->PackerUI->Form->setErrors($vres);
		}
		else
		{
			$cache["step2"]=$post;
			$this->Packer->Session->write(self::MFORM_CACHE,$cache);
			$this->redirect("@mform/step3/");
		}

	}
	else{

		if(!empty(Request::$get["data_keep"])){
			if(!empty($cache["step2"])){
				Request::$post=$cache["step2"];
			}
		}
	}

}
```

### # Step3(action)

```php
	public function step3(){

		$cache=$this->_verify([
			"step1",
			"step2",
		]);

		if(Request::$post){

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			$post=Request::$post;

			// validate check
			$vres=$this->Validator->Mform->verify($post,"v_step3");

			if($vres){
				$this->PackerUI->Form->setErrors($vres);
			}
			else
			{
				$cache["step3"]=$post;
				$this->Packer->Session->write(self::MFORM_CACHE,$cache);
				$this->redirect("@mform/step4/");
			}

		}
		else{

			if(!empty(Request::$get["data_keep"])){
				if(!empty($cache["step3"])){
					Request::$post=$cache["step3"];
				}
			}
		}

	}
```

### # Step4(action)

```php
	public function step4(){

		$cache=$this->_verify([
			"step1",
			"step2",
			"step3",
		]);

		if(Request::$post){

			// token check
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			$post=Request::$post;

			// validate check
			$vres=$this->Validator->Mform->verify($post,"v_step4");

			if($vres){
				$this->PackerUI->Form->setErrors($vres);
			}
			else
			{
				$cache["step4"]=$post;
				$this->Packer->Session->write(self::MFORM_CACHE,$cache);
				$this->redirect("@mform/confirm/");
			}

		}
		else{

			if(!empty(Request::$get["data_keep"])){
				if(!empty($cache["step4"])){
					Request::$post=$cache["step4"];
				}
			}
		}

	}
```

### # Confirm

```php
	public function confirm(){

		$cache=$this->_verify([
			"step1",
			"step2",
			"step3",
			"step4",
		]);

		$this->set("cache",$cache);

		if(Request::$post){
			
			if(!$this->Packer->Form->verify()){
				echo "ERROR : ".self::AUTHORITY_ERROR_MESSAGE;
				exit;
			}

			/**
			 *
			 * Perform the procedure here (scheduled)...
			 *  
			 * 
			 */

			$cache["complete"]=$post;
			$this->Packer->Session->write(self::MFORM_CACHE,$cache);
			$this->redirect("@mform/complete/");

		}
	}
```

### # Complete page

```php
	 public function complete(){

		$cache=$this->_verify([
			"step1",
			"step2",
			"step3",
			"step4",
			"complete",
		]);

		//cache clear
		$this->Packer->Session->delete(self::MFORM_CACHE);
		
	 }
```