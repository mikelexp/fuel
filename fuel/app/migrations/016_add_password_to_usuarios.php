<?php

namespace Fuel\Migrations;

class Add_password_to_usuarios
{
	public function up()
	{
		\DBUtil::add_fields('usuarios', array(
			'password' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('usuarios', array(
			'password'

		));
	}
}