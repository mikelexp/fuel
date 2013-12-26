<?php

namespace Fuel\Migrations;

class Delete_deleted_at_from_productos
{
	public function up()
	{
		\DBUtil::drop_fields('productos', array(
			'deleted_at'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('productos', array(
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}
}