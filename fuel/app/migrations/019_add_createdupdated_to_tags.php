<?php

namespace Fuel\Migrations;

class Add_createdupdated_to_tags
{
	public function up()
	{
		\DBUtil::add_fields('tags', array(
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('tags', array(
			'created_at'
,			'updated_at'

		));
	}
}