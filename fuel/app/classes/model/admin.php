<?php

/**
 * Class Model_Admin
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $usuario
 * @property string $password
 * @property boolean $activo
 */

class Model_Admin extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'nombre',
		'email',
		'usuario',
		'password',
		'activo',
		'created_at',
		'updated_at',
		'deleted_at'
	);

	protected static $_table_name = "admins";

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
		"mysql_timestamp" => false
	);

	public static function activar($id) {

		$item = Model_Admin::find($id);

		if (!$item)
			throw new Exception("El administrador no existe");

		$item->activo = $item->activo ? false : true;
		$item->save();

		return $item->activo ? "desactivar" : "activar";

	}

}
