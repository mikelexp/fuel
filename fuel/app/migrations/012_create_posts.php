<?php

namespace Fuel\Migrations;

class Create_posts
{
	public function up()
	{
		\DBUtil::create_table('posts', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'usuario_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'titulo' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'texto' => array('type' => 'text', 'null' => true),
			'fecha' => array('type' => 'datetime', 'null' => true),
			'activo' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('posts');
	}
}