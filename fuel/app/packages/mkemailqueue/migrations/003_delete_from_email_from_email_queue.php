<?php

namespace Fuel\Migrations;

class Delete_from_email_from_email_queue
{
	public function up()
	{
		\DBUtil::drop_fields('email_queue', array(
			'from_email'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('email_queue', array(
			'from_email' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),

		));
	}
}