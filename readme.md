# Test Sample(Multiple Page Form)

This is a test sample of a procedure form consisting of multiple pages.

It can be used for input procedures that combine multiple pages such as for order flow and new member registration.

# Main adjustment points

## 1. Structure

Input data for each page is stored in Session.  
The retained data is also stored in the Session for each page and temporarily stored, so it is also used for authentication for each page.

---

## 2. Change routing content

Make sure the routes for pages in ``/apps/AP1/AppConf/routing.php`` are as follows.

```php
"pages"=>[
	"/"=>"main@index",
	"/mform/step1"=>"mform@step1",
	"/mform/step2"=>"mform@step2",
	"/mform/step3"=>"mform@step3",
	"/mform/step4"=>"mform@step4",
	"/mform/confirm"=>"mform@confirm",
	"/mform/complete"=>"mform@complete",
],
```

---

## 3. Code description of MformController

Open the ``MformController.php`` file in the ``apps/AP1/Backend/Controller`` directory and make sure the code looks like this:

### # constant

Set the constant used in Controller.

The constant MFORM_CACHE is the storage location of the input data Session.  
The constant AUTHORITY_ERROR_MESSAGE is the error message displayed when checking (CSRF check) when invalid input data is received.

```php
const MFORM_CACHE="__mform_cache__";
const AUTHORITY_ERROR_MESSAGE="The process was interrupted, judging that it was an unauthorized access.";
```

### # constructor

