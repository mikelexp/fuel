<?php

namespace Fuel\Migrations;

class Add_deleted_at_to_admins
{
	public function up()
	{
		\DBUtil::add_fields('admins', array(
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('admins', array(
			'deleted_at'

		));
	}
}