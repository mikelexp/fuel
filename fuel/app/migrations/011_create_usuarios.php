<?php

namespace Fuel\Migrations;

class Create_usuarios
{
	public function up()
	{
		\DBUtil::create_table('usuarios', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'nombre' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'apellido' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'email' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'fecha_nacimiento' => array('type' => 'date', 'null' => true),
			'activo' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('usuarios');
	}
}