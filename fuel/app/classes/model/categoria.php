<?php

class Model_Categoria extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'nombre',
		'orden',
		'activo',
		'created_at',
		'updated_at',
		'deleted_at',
	);

	protected static $_table_name = "categorias";

	protected static $_has_many = array(
		"productos" => array(
			"model_to" => "Model_Producto",
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
	
	public static function activar($id) {

		$item = Model_Categoria::find($id);

		if (!$item)
			throw new Exception("La categoría no existe");

		$item->activo = $item->activo ? false : true;
		$item->save();

		return $item->activo ? "desactivar" : "activar";

	}

}
