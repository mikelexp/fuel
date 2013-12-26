<?php

namespace Fuel\Migrations;

class Add_deletedat_to_tags
{
	public function up()
	{
		\DBUtil::add_fields('tags', array(
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('tags', array(
			'deleted_at'

		));
	}
}