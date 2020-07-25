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

### #.constructor

Make sure the constructor is set as shown below.

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

	// allow action set
	$this->Packer->SampleAuth->allowList=[
		"@auth/create",
	];

	// login check
	$this->Packer->SampleAuth->loginCheck();

	// send message setting
	if($this->Packer->Session->read("sendMsg")){
		$this->set("sendMsg",$this->Packer->Session->flash("sendMsg"));
	}

}
```