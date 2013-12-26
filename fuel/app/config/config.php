<?php

return array(

	"language" => "es",
	"locale" => "es_AR",
	"log_threshold" => Fuel::L_ALL,
	'security' => array(
		'output_filter'  => array(),
	),
	'module_paths' => array(
		APPPATH.'modules'.DS
	),
	'package_paths' => array(
		PKGPATH,
		APPPATH.'packages'.DS
	),
	'always_load'  => array(
		'packages'  => array(
			'orm',
			'mkautocreate',
			'mkauth',
			'mkmessages',
			'mkpagination',
			'mkforms',
			'mkbrowserphp',
			'mkemailqueue',
			'mkswf',
			'mkappconfig'
		),
	),

);
