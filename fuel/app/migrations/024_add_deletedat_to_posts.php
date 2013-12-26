<?php

namespace Fuel\Migrations;

class Add_deletedat_to_posts
{
	public function up()
	{
		\DBUtil::add_fields('posts', array(
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('posts', array(
			'deleted_at'

		));
	}
}