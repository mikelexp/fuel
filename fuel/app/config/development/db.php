<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	"default" => array(
		"type" => "mysql",
		"connection" => array(
			"hostname" => "localhost",
			"port" => 3306,
			"database" => "the_ultimate_fuelphp_setup",
			"username" => "root",
			"password" => "",
			"persistent" => true,
			"compress" => false
		)
	)
);
