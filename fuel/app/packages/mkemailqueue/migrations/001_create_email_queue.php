<?php

namespace Fuel\Migrations;

class Create_email_queue
{
	public function up()
	{
		\DBUtil::create_table('email_queue', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'from_email' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'from_name' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'tos' => array('type' => 'text', 'null' => true),
			'ccs' => array('type' => 'text', 'null' => true),
			'bccs' => array('type' => 'text', 'null' => true),
			'subject' => array('type' => 'text', 'null' => true),
			'message_plain' => array('type' => 'text', 'null' => true),
			'message_html' => array('type' => 'text', 'null' => true),
			'attachs' => array('type' => 'text', 'null' => true),
			'fecha_creacion' => array('type' => 'datetime', 'null' => true),
			'prioritario' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),
			'procesado' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),
			'fecha_procesado' => array('type' => 'datetime', 'null' => true),
			'ok' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),
			'error_string' => array('type' => 'text', 'null' => true),
			'extra_info' => array('type' => 'text', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('email_queue');
	}
}