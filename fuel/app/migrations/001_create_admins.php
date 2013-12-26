<?php

namespace Fuel\Migrations;

class Create_admins
{
	public function up()
	{
		\DBUtil::create_table('admins', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'nombre' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'email' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'usuario' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'password' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'activo' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admins');
	}
}