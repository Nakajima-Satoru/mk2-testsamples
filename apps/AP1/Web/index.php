<?php

/**
 * input.php
 * 
 * Web/input.php
 * 
 * framework startor.
 * 
 * @copyright	 Copyright (C) Nakajima Satoru. 
 * @link		 https://www.mk2-php.com/
 * 
 */

use mk2\core\Mk2Gen;

require "../../../vendor/autoload.php";

/*
If you want to change the namespace arbitrarily, enable the following constants
Specify in any namespace.
*/

# const MK2_NAMESPACE="mark2";

/*
If you change or duplicate the directory name, 
please enter the directory name in the following constant
*/

# const MK2_SYSNAME="AP2";

new Mk2Gen();