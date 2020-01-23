# Test Sample_0004

When the routing mode is set to "auto".

# Main adjustment points

## 1. Change "routeMode" in config.php

Change "routeMode" to "auto" in **/apps/AP1/AppConf/config.php**.

```php
"routeMode"=>"auto",
```

## 2. Change routing content


Change routing in pages of **/apps/AP1/AppConf/routing.php** to null.

```php
<?php

...

return [

	/**
	 * pages
	 * 
	 * Click here for routing on each page (end point).
	 */

	"pages"=>[],

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
```

After that, set up various controllers and actions and verify whether they can actually be accessed.

<hr>

HP : https://www.mk2-php.tech/  
Copylight (C) Nakajima Satoru.