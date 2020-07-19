# Test Sample(Change Directory Structure)

Changed directory structure of Controller, Packer, Model etc.

# Main adjustment points

## 1. Change directory structure and directory names

Change to the following directory structure.

```
/apps
	L /AP1
		L /00_AppConf
		L /01_Controller
		L /02_Packer
		L /03_Shell
		L /04_Model
		L /05_Table
		L /06_Validator
		L /07_Render
		L /08_Template
		L /09_ViewPart
		L /10_Web
		L .htaccess
```

## 2. Change .htaccess redirect destination

Change RewriteRule path of **/apps/AP1/.htaccess**.

```
<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteRule ^$ 10_Web/ [L]
	RewriteRule (.*) 10_Web/$1 [L]
</IfModule>
```

## 3. Set constant value of directory path

Set various constant values ​​in **/apps/AP1/10_Web/input.php** as follows.

```php
<?php

...

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
```

<hr>

HP : https://www.mk2-php.com/  
Copylight (C) Nakajima Satoru.