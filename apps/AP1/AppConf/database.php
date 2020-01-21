<?php

/**
 * 
 * database.php
 * 
 * AppConf/database.php
 * 
 * Designate each data base connection destination here.
 * A designated data base can be 
 * managed easily in the Model class every table.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

return[

	/**
	 * 
	 * database default
	 * 
	 * Default database connection information.
	 * 
	 */

	"default"=>[
		"type"=>"mysql",
		"host"=>"localhost",
		"username"=>"root",
		"password"=>"",
		"port"=>3306,
		"database"=>"mk2db",
		"encoding"=>"utf8mb4",
	],

	/**
	 * 
	 * database test
	 * 
	 * Test database connection information.
	 * 
	 */

	"test"=>[
		"type"=>"mysql",
		"host"=>"localhost",
		"username"=>"root",
		"password"=>"",
		"port"=>3306,
		"database"=>"mk2dbsample_test",
		"encoding"=>"utf8mb4",
	],
	
];