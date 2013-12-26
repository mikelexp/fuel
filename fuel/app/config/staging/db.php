<?php
/**
 * The staging database settings. These get merged with the global settings.
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
