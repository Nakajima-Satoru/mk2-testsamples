<?php

/**
 * 
 * config.php
 * 
 * AppConf/config.php
 * 
 * Make sure to optimize these settings after installation is complete.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

return[

	# routeMode
	#
	# auto    : Routing is automatically assigned according to Mk2's naming convention.
	# manual  : There is no automatic assignment according to Mk2's naming convention for routing.
	#           Routing must be specified when adding a new page.
	#           Routing is specified in the routing.php file.
	# onepage : Access concentrates on only one page without routing.
	#           The controller and action specified by defControls are the actual access destinations.

	"routeMode"=>"manual",

	# fullPath
	#
	# Specify 'true' if you want to change URL
	# information from absolute path to relative path

	"fullPath"=>false,

	# defControls
	# 
	# Specifies the default controller and action.

	"defControls"=>[
		"controller"=>"main",
		"action"=>"index",
	],

	# defHeader
	#
	# default Response Header Setting.
	
	"defHeader"=>[
		"Content-Type"=>"text/html; charset=utf-8",
		"Cache-Control"=>"max-age=0",
	],

	# use class
	#
	# The required classes are specified here.
	# For example, if you use it as a 
	# mere API instead of a web page, 
	# removing 'Render' to output 
	# HTML will improve server performance 
	# by eliminating them.

	"useClass"=>[
		"Controller",
		"Packer",
		"Shell",
		"Model",
		"Table",
		"Validator",
		"Render",
	],

	# allow directory
	#
	# If you want to add a class subdirectory 
	# as a reference, please add it here.

	/*
	"allowDirectory"=>[
		"Controller"=>["Sub"],
	],
	*/

	# Database Shecma
	#
	# You can set the database schema to connect here.
	# If there are a lot of connections, please divide into separate files

	"database"=>include(MK2_PATH_APPCONF."database.php"),

	# Routing
	#
	# You can set the routing for each URL.
	# If there are a lot of connections, please divide into separate files

	"routing"=>include(MK2_PATH_APPCONF."routing.php"),

	# optionInclude
	#
	# If you want to prepare your own constants and other common methods, 
	# specify them here and they will be loaded automatically.
	# Be sure to prepare a file to read.(An error occurs if it does not exist.)

	/*
	"optionInclude"=>[
		"Config/const.php",
	],
	*/
];