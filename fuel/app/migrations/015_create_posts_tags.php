<?php

namespace Fuel\Migrations;

class Create_posts_tags
{
	public function up()
	{
		\DBUtil::create_table('posts_tags', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'post_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'tag_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('posts_tags');
	}
}