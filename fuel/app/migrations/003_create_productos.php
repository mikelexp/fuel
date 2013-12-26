<?php

namespace Fuel\Migrations;

class Create_productos
{
	public function up()
	{
		\DBUtil::create_table('productos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'categoria_id' => array('constraint' => 20, 'type' => 'bigint', 'null' => true),
			'nombre' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'descripcion' => array('type' => 'text', 'null' => true),
			'foto' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'activo' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('productos');
	}
}