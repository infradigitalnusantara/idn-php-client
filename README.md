**INFRA DIGITAL NUSANTARA APIs**

This is APIs library used for doing request to IDN endpoint.

You may install this library from composer. 
You can install this library using this command 
`composer require infradigital/api-client` 
or by registering the library packagist namespace into your composer.json file
`{
     "require": {
         "infradigital/api-client": "1.*"
     }
 }` then invoke the composer install command
 `php composer install`
 
 **_HOW TO_**
 
 To initiate the API class you can import first the ApiClient class like this
 `use InfraDigital\ApiClient;` 
 then initiate it in your php code 
 ````
 $idnClient = new ApiClient\Client($idnUserName, $idnPassword);
 ````
 
 Once you already initiate the class you can use like this example
 ````
 $idnClient->studentApi()->createStudent('Test User 1234' . date('YMDhis'), 'testBillKey01234' . date('YMDhis'),'0987612345', 'use.only@valid.domain', 'This is test to create user');
 ````
  
 So it would look like this if we put it together
 
 ````
 use InfraDigital\ApiClient;
 
 $idnClient = new ApiClient\Client($idnUserName, $idnPassword);
 $idnClient->studentApi()->createStudent('Test User 1234' . date('YMDhis'), 'testBillKey01234' . date('YMDhis'),'0987612345', 'use.only@valid.domain', 'This is test to create user');
 ````
 
 You may put this short of code `$idnClient->setDevMode();` after you initiate the class. Instead it will use IDN production domain as default uri.
 
  ````
  $idnClient = new ApiClient\Client($idnUserName, $idnPassword);
  $idnClient->setDevMode(); // This will be tell the class to use development uri
  $idnClient->studentApi()->createStudent('Test User 1234' . date('YMDhis'), 'testBillKey01234' . date('YMDhis'),'0987612345', 'use.only@valid.domain', 'This is test to create user');
  ````