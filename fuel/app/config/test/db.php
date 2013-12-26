<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return array(
	"default" => array(
		"type" => "mysql",
		"connection" => array(
			"hostname" => "localhost",
			"port" => 3306,
			"database" => "",
			"username" => "",
			"password" => "",
			"persistent" => true,
			"compress" => false
		)
	)
);
