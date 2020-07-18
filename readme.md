# Test Sample (Direct)

The system screen is displayed immediately below the directory.

# Main adjustment points

## 1. Moving and modifying .htaccess files

After moving .htaccess to **/** below **/apps/AP1/Web/.htaccess**, modify it to the following code.

```
<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteRule ^$ apps/AP1/Web/ [L]
	RewriteRule (.*) apps/AP1/Web/$1 [L]
</IfModule>
```

## 2. Partial code change of startor index.php file

Some code changes in **/apps/AP1/Web/index.php**.

```php
<?php

...

use mk2\core\Mk2Gen;

require "../../../vendor/autoload.php";

# Change root level to 3...
const MK2_ROOT_LEVEL=3;

new Mk2Gen();
```

The constant **MK2_ROOT_LEVEL** is set to 3.

```php
const MK2_ROOT_LEVEL=3;
```

<hr>

HP : https://www.mk2-php.tech/  
Copylight (C) Nakajima Satoru.