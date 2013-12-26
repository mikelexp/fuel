<?

namespace Mkmessages;

use \Fuel\Core\Session;

class Mkmessages {

	public static function add($message, $type = "success") {
		$messages = self::get();
		$messages[] = array(
			"message" => $message,
			"type" => $type
		);
		Session::set_flash("messages", $messages);
	}

	public static function get() {
		return Session::get_flash("messages", array());
	}

	public static function clear() {
		Session::delete_flash("messages");
	}

}
