<?php

/**
 * 
 * routing.php
 * 
 * AppConf/routing.php
 * 
 * Routing is basically a function that enables route search between the URL and 'Controller' and 'View' in / app.
 * Basically, in 'Mk2', URLs for which no routing is specified are automatically 
 * connected to 'Controller' and 'View' according to the naming rules.
 * 
 * http://localhost/{Controller name}/{action name}/{argument}...
 * 
 * If you are satisfied with this, no routing is necessary.
 * However, if the client requests a URL in detail or if you want to centrally 
 * manage which Controller and action are assigned to which page, you need to set up a routing.
 * 
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

return [

	/**
	 * pages
	 * 
	 * Click here for routing on each page (end point).
	 */

	"pages"=>[
		"/"=>"main@index",
		"/dbtable"=>"dbtable@index",
		"/dbtable/register"=>"dbtable@edit",
		"/dbtable/edit/{:id}"=>"dbtable@edit",
		"/dbtable/confirm"=>"dbtable@confirm",
		"/dbtable/delete/{:id}"=>"dbtable@delete",
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