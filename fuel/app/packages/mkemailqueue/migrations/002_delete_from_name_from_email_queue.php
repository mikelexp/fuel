<?php

namespace Fuel\Migrations;

class Delete_from_name_from_email_queue
{
	public function up()
	{
		\DBUtil::drop_fields('email_queue', array(
			'from_name'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('email_queue', array(
			'from_name' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),

		));
	}
}