# Test Sample(Change Namespace)

Change to your own namespace.

# Main adjustment points

## 1. Declaration of constants for namespace

In the code of **/apps/AP1/Web/input.php**, set only constant value for namespace as follows

```php
<?php

use mk2\core\Mk2Gen;

require "../../../vendor/autoload.php";

/*
If you want to change the namespace arbitrarily, enable the following constants
Specify in any namespace.
*/

const MK2_NAMESPACE="sample_0003";

new Mk2Gen();
```

<hr>

## 2. Specifying the namespace of each class such as Controller

Just change the namespace of each class such as Controller to the namespace specified below.

```php
<?php

namespace sample_0003;

use mk2\core\Controller;

class AppController extends Controller{

	public $Template="default";
	public $autoRender=true;
	
}
```

If the static class method or the namespace specified by the inheritance class is the namespace, specify the use clause.

```php
<?php


namespace sample_0003;

use mk2\core\Import;

Import::Controller("App");

class MainController extends AppController{

	# Top page
	public function index(){}
}
```

<hr>

HP : https://www.mk2-php.tech/  
Copylight (C) Nakajima Satoru.