<?php

namespace Fuel\Migrations;

class Create_posts_comentarios
{
	public function up()
	{
		\DBUtil::create_table('posts_comentarios', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'post_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'usuario_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'fecha' => array('type' => 'datetime', 'null' => true),
			'activo' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('posts_comentarios');
	}
}