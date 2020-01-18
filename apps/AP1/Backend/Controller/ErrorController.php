<?php

/**
 * ErrorController
 * 
 * Backend/Controller/ErrorController.php
 * 
 * Error page output controller.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace sample_0003;

use mk2\core\Import;

Import::Controller("App");

class ErrorController extends AppController{

	# 404(page not found)

	public function page404($e){
		$this->set("pageTitle","404 Not Found!");
		$this->set("err",$e);
	}

	# 500(Internal Server Error)

	public function page500($e){
		$this->set("pageTitle","500 Internal Server Error!");
		$this->set("err",$e);
	}
	
}