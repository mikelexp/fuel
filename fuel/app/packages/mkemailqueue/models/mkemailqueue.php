<?

namespace Mkemailqueue;

use Orm\Model;

class Model_Mkemailqueue extends Model {

	protected static $_properties = array(
		'id',
		'tos',
		'ccs',
		'bccs',
		'subject',
		'message_plain',
		'message_html',
		'attachs',
		'fecha_creacion',
		'prioritario',
		'procesado',
		'fecha_procesado',
		'ok',
		'error_string',
		'extra_info',
		'from',
	);

	protected static $_table_name = "email_queue";

}
