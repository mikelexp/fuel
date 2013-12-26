<?

Autoloader::add_core_namespace('Mkemailqueue');

Autoloader::add_classes(array(
	'Mkemailqueue\\Mkemailqueue' => __DIR__.'/classes/mkemailqueue.php',
	'Mkemailqueue\\Model_Mkemailqueue' => __DIR__.'/models/mkemailqueue.php',
));
