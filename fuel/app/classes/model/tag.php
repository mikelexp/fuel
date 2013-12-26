<?php

class Model_Tag extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'tag',
		'created_at',
		'updated_at',
		'deleted_at',
	);

	protected static $_table_name = "tags";

	protected static $_many_many = array(
		"posts" => array(
			"model_to" => "Model_Post",
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
