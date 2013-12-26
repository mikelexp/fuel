<?php

namespace Fuel\Migrations;

class Add_from_to_email_queue
{
	public function up()
	{
		\DBUtil::add_fields('email_queue', array(
			'from' => array('type' => 'text', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('email_queue', array(
			'from'

		));
	}
}