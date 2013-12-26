<?php

use Fuel\Core\File;
use Fuel\Core\Image;

class Model_Producto extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'categoria_id',
		'nombre',
		'descripcion',
		'foto',
		'fecha',
		'activo',
		'created_at',
		'updated_at',
		'deleted_at',
	);

	protected static $_table_name = "productos";

	protected static $_belongs_to = array("categoria" => array("model_to" => "Model_Categoria"));

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

		$item = Model_Producto::find($id);

		if (!$item)
			throw new Exception("El producto no existe");

		$item->activo = $item->activo ? false : true;
		$item->save();

		return $item->activo ? "desactivar" : "activar";

	}

	public static function procesar_imagenes(Model_Producto $producto) {

		$sizes = array(
			"big" => array(
				"size" => 640,
			),
			"small" => array(
				"size" => 200,
			),
		);

		$dir = DOCROOT.DS."uploads".DS;

		if (file_exists($dir.$producto->foto)) {

			foreach ($sizes as $name => $params) {
				$image = Image::forge(array(
					"quality" => 90
				));
				$image->load($dir.$producto->foto);
				$image->resize($params['size'], $params['size']);
				$image->save($dir.$name."_".$producto->foto);
			}

			File::delete($dir.$producto->foto);

		}

	}

}
