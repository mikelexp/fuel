<?php

namespace Fuel\Migrations;

class Add_fecha_to_productos
{
	public function up()
	{
		\DBUtil::add_fields('productos', array(
			'fecha' => array('type' => 'datetime', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('productos', array(
			'fecha'

		));
	}
}