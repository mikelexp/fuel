<?

Autoloader::add_core_namespace('Mkauth');

Autoloader::add_classes(array(
	'Mkauth\\Mkauth' => __DIR__.'/classes/mkauth.php',
	'Mkauth\\MkauthException' => __DIR__.'/classes/mkauth.php'
));
