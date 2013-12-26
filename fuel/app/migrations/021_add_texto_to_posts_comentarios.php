<?php

namespace Fuel\Migrations;

class Add_texto_to_posts_comentarios
{
	public function up()
	{
		\DBUtil::add_fields('posts_comentarios', array(
			'texto' => array('type' => 'text', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('posts_comentarios', array(
			'texto'

		));
	}
}