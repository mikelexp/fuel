<?php

class Model_Usuario extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'nombre',
		'apellido',
		'email',
		'password',
		'fecha_nacimiento',
		'activo',
		'created_at',
		'updated_at',
		'deleted_at',
	);

	protected static $_table_name = "usuarios";

	protected static $_has_many = array(
		"posts" => array(
			"model_to" => "Model_Post",
			"cascade_delete" => true,
		),
		"comentarios" => array(
			"model_to" => "Model_Post_Comentario",
			"cascade_delete" => true,
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_soft_delete = array(
		"mysql_timestamp" => false,
	);

}
