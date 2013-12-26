<?

Autoloader::add_core_namespace('Mkcart');

Autoloader::add_classes(array(
	'Mkcart\\Mkcart' => __DIR__.'/classes/mkcart.php',
	'Mkcart\\Mkcartitem' => __DIR__.'/classes/mkcart.php',
	'Mkcart\\Mkcartcupon' => __DIR__.'/classes/mkcart.php',
));
