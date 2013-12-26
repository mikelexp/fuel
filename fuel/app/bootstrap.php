<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';


Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
	'Form' => APPPATH.'classes/form.php',
	'Asset' => APPPATH.'classes/asset.php',
	'Html' => APPPATH.'classes/html.php',
	'Uri' => APPPATH.'classes/uri.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
if (isset($_SERVER['HTTP_HOST'])) {
	switch ($_SERVER['HTTP_HOST']) {
		case "theultimatefuelphpsetup":
		case "tufps.substance.com.ar":
			Fuel::$env = Fuel::DEVELOPMENT;
			break;
		default:
			Fuel::$env = Fuel::PRODUCTION;
	}
} else {
	Fuel::$env = getenv("FUEL_ENV") ?: Fuel::DEVELOPMENT;
}

// Initialize the framework with the config file.
Fuel::init('config.php');
