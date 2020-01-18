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

# Change all directory structure with following constants.
const MK2_PATH_APPCONF="../../../apps/AP1/00_AppConf/";
const MK2_PATH_APP_CONTROLLER="../../../apps/AP1/01_Controller/";
const MK2_PATH_APP_PACKER="../../../apps/AP1/02_Packer/";
const MK2_PATH_APP_SHELL="../../../apps/AP1/03_Shell/";
const MK2_PATH_APP_MODEL="../../../apps/AP1/04_Model/";
const MK2_PATH_APP_TABLE="../../../apps/AP1/05_Table/";
const MK2_PATH_APP_VALIDATOR="../../../apps/AP1/06_Validator/";
const MK2_PATH_APP_RENDER="../../../apps/AP1/07_Render/";
const MK2_PATH_APP_TEMPLATE="../../../apps/AP1/08_Template/";
const MK2_PATH_APP_VIEWPART="../../../apps/AP1/09_ViewPart/";
const MK2_PATH_WEB="../../../apps/AP1/10_Web/";

new Mk2Gen();