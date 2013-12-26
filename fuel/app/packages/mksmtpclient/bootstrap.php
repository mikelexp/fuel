<?

Autoloader::add_core_namespace('Mksmtpclient');

Autoloader::add_classes(array(
	'Mksmtpclient\\Mksmtpclient' => __DIR__.'/classes/mksmtpclient.php',
	'Mksmtpclient\\MksmtpclientException' => __DIR__.'/classes/mksmtpclient.php',
));
