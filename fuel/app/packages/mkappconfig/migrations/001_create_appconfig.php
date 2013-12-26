<?php

namespace Fuel\Migrations;

class Create_appconfig
{
	public function up()
	{
		\DBUtil::create_table('appconfig', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'key' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'value' => array('type' => 'text', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('appconfig');
	}
}