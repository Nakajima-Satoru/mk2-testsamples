# Test Sample(Database Table Control)

Sample of basic record management (list, registration/edit, delete) of database table.

# Main adjustment points

## 1. Database preparation

When you first press the "Database Table Control Sample" button on the TOP page and the following message is displayed,   
it means that the database server does not exist or the database tables have not been prepared.

```
Database Error.

It looks like the database is not connected or the database or table has not been created yet.
Connect to the database server and import the following SQL code to get ready.
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
	"database"=>"mk2db",
	"encoding"=>"utf8mb4",
],
```

After confirming that it is connected to the database connection destination, if the database (schema) does not exist, import the SQL data.

For SQL data, there is a SQL file in the following path, so import that.

```apps/AP1/Web/mk2_sql.sql```

---

## 2.  Change routing content

Make sure the routes for pages in ``/apps/AP1/AppConf/routing.php`` are as follows.

```php
"pages"=>[
	"/"=>"main@index",
	"/dbtable"=>"dbtable@index",
	"/dbtable/register"=>"dbtable@edit",
	"/dbtable/edit/{:id}"=>"dbtable@edit",
	"/dbtable/confirm"=>"dbtable@confirm",
	"/dbtable/delete/{:id}"=>"dbtable@delete",
],
```

---

## 3. Code description of DbtableController

Open the ``DbtableController.php`` file in the ``apps/AP1/Backend/Controller`` directory and make sure the code looks like this:

### # Form Cache Name

Make sure the private constant FORM_CACHE is set as shown below.  
This is used to temporarily save input data on Session on record registration/edit screen flow.

```php
const FORM_CACHE="__cache_dbtable1_edit";
```

### # constructor

Make sure the constructor is set as shown below.

```php
public function __construct(){
	parent::__construct();

	$this->setModel([
		"Dbtable1",
	])
	->setPacker([
		"Form",
		"Session",
		"Paginate",
	]);
	$this->set("sendMsg",$this->Packer->Session->flash("sendMsg"));
	$this->set("dangerMsg",$this->Packer->Session->flash("dangerMsg"));

}
```

I will explain step by step.

Since Dbtable1Model handles all business logic this time, specify Dbtable1 in setModel.

```php
$this->setModel([
	"Dbtable1",
])
->setPacker([
	"Form"=>[
		"cssFramework"=>"bootstrap",
	],
	"Session",
	"Paginate",
]);
```

Packer class uses FormPacker for generating Form tag, SessionPacker for managing Session data, and PaginatePacker for setting paging.

Since the sample uses bootstrap as the CSS framework, I'll make it explicit in FormPacker.

Write the code to display the message on the Render side when record registration/update is completed or when record processing fails.

```php
$this->set("sendMsg",$this->Packer->Session->flash("sendMsg"));
$this->set("dangerMsg",$this->Packer->Session->flash("dangerMsg"));
```

### # index (table recode list)

Set the action to display the record list of the database table.  
Make sure the code is written as follows:

```php
public function index(){

	// search recode..
	$res=$this->Model->Dbtable1->get(null,Request::$get);
	$this->set("res",$res);

}
```

The get method in Dbtable1Model will be described later, but here you get a list of table information.

### # edit (table recode insert/update)

Set up actions to register and edit database tables.  
Make sure the code is written as follows:

```php
public function edit($id=null){

	if(Request::$post){

		// if Request Data(POST) then...

		//verify check
		if(!$this->Packer->Form->verify()){
			echo "ERROR! : Processing was interrupted due to unauthorized access.";
			exit;
		}

		$post=Request::$post;

		$post["id"]=$id;

		// input data validate..
		$vres=$this->Model->Dbtable1->validate($post);

		if($vres){

			// output validate error message..
			$this->Packer->Form->setErrors($vres);

		}
		else
		{

			// write session cache..
			$this->Packer->Session->write(self::FORM_CACHE,$post);

			// next confirm page..
			return $this->redirect("@dbtable/confirm/");

		}

	}
	else
	{

		// if no exist Request Data(POST) then...

		if($id){

			// get recode data...
			$res=$this->Model->Dbtable1->get($id);

			if(!empty($res)){
				Request::$post=(array)$res;
			}
			else{
				$this->Packer->Session->write("dangerMsg","Editing stopped because no records were found.");
				return $this->redirect("@dbtable/");
			}
		}

		if(!empty(Request::$get["data_keep"])){
			$cache=$this->Packer->Session->read(self::FORM_CACHE);
			Request::$post=$cache;
		}

	}

}
```

### # confirm (table recode insert/update)

Set up a confirmation screen for the above record registration/edit flow.  
Make sure the code is written as follows:

```php
public function confirm(){

	// cache check
	$cache=$this->Packer->Session->read(self::FORM_CACHE);
	if(!$cache){
		$this->redirect("@dbtable/register/");
	}

	$this->set("cache",$cache);

	if(Request::$post){

		//verify check
		if(!$this->Packer->Form->verify()){
			echo "ERROR! : Processing was interrupted due to unauthorized access.";
			exit;
		}
	
		// recode insert/update process
		$res=$this->Model->Dbtable1->process($cache);
	
		$this->Packer->Session->delete(self::FORM_CACHE);
					
		if(!empty($res["flg"])){
			$this->Packer->Session->write("sendMsg","Record update/registration completed");
		}
		else{
			$this->Packer->Session->write("dangerMsg","Record update/registration failed. <br>Error : ".$res["error"]);
		}
		return $this->redirect("@dbtable/");
	
	}
}
```

### # delete

Set up an action for deleting records.  
Make sure the code is written as follows:

```php
public function delete($id){
	$this->autoRender=false;

	// recode delete...
	$res=$this->Model->Dbtable1->delete($id);

	if(!empty($res["flg"])){
		$this->Packer->Session->write("sendMsg","One record deleted");
	}
	else{
		$this->Packer->Session->write("dangerMsg","Deletion of record failed. \n".$res["error"]);
	}
	$this->redirect("@dbtable/");

}
```

---

## 4. Code description of Dbtable1Model

Open the ``Dbtable1Model.php`` file in the ``apps/AP1/Middle/Model`` directory and make sure the code looks like this:

### # constructor

Make sure the constructor is set as shown below.  
To use Dbtable1Table for table connection (Data access object-DAO) and Dbtable1Validator for validation, load each as follows.

```php
public function __construct(){
	parent::__construct();

	$this->setTable([
		"Dbtable1",
	])
	->setValidator([
		"Dbtable1",
	]);

}
```

### # get recode 

Set up a get method to get record information.  
Depending on the presence or absence of the argument $id, if there is no, get the list with paging information, and if there is, get the detailed information.

This is just an example, so if you don't like nesting,  
It is okay to separate methods for list acquisition and details acquisition

```php
public function get($id=null,$query=null){

	try{

		if($id){

			// get recode detail
		
			$res=$this->Table->Dbtable1->select([
				"type"=>"first",
				"where"=>[
					["id",$id],
					["delete_flg",0],
				],
			]);

			return $res;

		}
		else
		{

			// get recode list

			$limit=5;
			$page=1;
		
			if($query){
			
				if(!empty($query["limit"])){
					$limit=$query["limit"];
				}
				if(!empty($query["page"])){
					$page=$query["page"];
				}
			
			}
				
			$res=$this->Table->Dbtable1->select([
				"type"=>"all",
				"where"=>[
					["delete_flg",0],
				],
				"paginate"=>[$limit,$page],
			]);

			return $res;
		
		}

	}catch(\Exception $e){
		return false;
	}

}
```

### # validate

Set the validate method for validation as shown below.

Basically it is simple because it is a wrapper of Validator class
If the verification item changes depending on the contents of the input data,  
 add the necessary code in this method.

```php
public function validate($post){

	$juge=$this->Validator->Dbtable1->verify($post);
	return $juge;
		
}
```

### # process (recode insert/update)

Set process method for registering or updating record information as shown below.

```php
public function process($cache){

	try{

		$tableObj=$this->Table->Dbtable1->save()->tsBegin();

		$entity=[
			"id"=>$cache["id"],
			"name"=>$cache["name"],
			"code"=>$cache["code"],
			"caption"=>$cache["caption"],
		];

		// save
		$res=$tableObj->save($entity);

		$tableObj->tsCommit();

		return [
			"flg"=>true,
		];
		
	}catch(\Exception $e){
		$tableObj->tsRollback();
		return [
			"flg"=>false,
			"error"=>$e,
		];
	}

}
```

### # recode delete

Set the delete method to delete the record information as shown below.

In the sample, record deletion is logical deletion, not physical deletion.

If you want to physically delete the record, it will be deleted by using ``$this->Dbtable1->delete($id)``.

```php
public function delete($id){

	# existCheck
	$existCheck=$this->get($id);

	if(!$existCheck){
		return false;
	}

	try{

		$tableObj=$this->Table->Dbtable1->save()->tsBegin();

		$entity=[
			"id"=>$id,
			"delete_flg"=>1,
		];

		$tableObj->save($entity);
			
		$tableObj->tsCommit();

		return [
			"flg"=>true,
		];

	}catch(\Exception $e){
		$tableObj->tsRollback();
		return[
			"error"=>$e,
		];
	}

}
```

---

## 5. Rendering

Each page has a view file in the ``apps/AP1/Rendering/Render`` directory.

---

HP : https://www.mk2-php.com/  
Copylight (C) Nakajima Satoru.