<?php

/**
 * MainController
 * 
 * Backend/Controller/MainController.php
 * 
 * Top page or other screen controller.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

namespace sample_0003;

use mk2\core\Import;

Import::Controller("App");

class MainController extends AppController{

	# Top page
	public function index(){}
}