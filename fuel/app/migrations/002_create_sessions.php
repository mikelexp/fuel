<?php

namespace Fuel\Migrations;

class Create_sessions
{
	public function up()
	{
		\DBUtil::create_table('sessions', array(
			'session_id' => array('constraint' => 40, 'type' => 'varchar'),
			'previous_id' => array('constraint' => 40, 'type' => 'varchar'),
			'user_agent' => array('type' => 'text'),
			'ip_hash' => array('constraint' => 32, 'type' => 'char'),
			'created' => array('constraint' => 10, 'type' => 'int'),
			'updated' => array('constraint' => 10, 'type' => 'int'),
			'payload' => array('type' => 'longtext'),

		));
	}

	public function down()
	{
		\DBUtil::drop_table('sessions');
	}
}