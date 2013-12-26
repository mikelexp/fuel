<?php

class Model_Post extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'usuario_id',
		'titulo',
		'texto',
		'fecha',
		'activo',
		'created_at',
		'updated_at',
		'deleted_at',
	);

	protected static $_table_name = "posts";

	protected static $_belongs_to = array(
		"usuario"
	);

	protected static $_has_many = array(
		"comentarios" => array(
			"model_to" => "Model_Post_Comentario",
			"cascade_delete" => true,
		),
	);

	protected static $_many_many = array(
		"tags" => array(
			"model_to" => "Model_Tag"
		)
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
