<?

namespace Mkappconfig;

use Fuel\Core\Cookie;
use Fuel\Core\DB;
use Fuel\Core\Session;

class Mkappconfig {

	/**
	 *
	 * Devuelve un valor
	 *
	 * $key: el nombre del valor
	 * $default_value: valor a devolver por defecto si el key no existe
	 * $set_if_not_present: guardar el valor si el key no existe
	 * $mode: modo de almacenamiento del valor: db/cookie/session - default: db
	 *
	 * @param string $key
	 * @param mixed $default_value
	 * @param boolean $set_if_not_present
	 * @param string $mode
	 * @return mixed
	 */
	public static function get($key, $default_value = null, $set_if_not_present = false, $mode = "db") {
		if (!empty($key)) {
			switch ($mode) {
				case "db":
					$response = DB::select()->from("appconfig")->where("key", $key)->limit(1)->execute();
					if (count($response) > 0) {
						return($response[0]['value']);
					} else {
						if ($set_if_not_present) {
							self::set($key, $default_value);
						}
						return($default_value);
					}
					break;
				case "cookie":
					if (self::exists($key, "cookie")) {
						return Cookie::get($key);
					} else {
						if ($set_if_not_present) {
							self::set($key, $default_value, "cookie");
						}
						return $default_value;
					}
					break;
				case "session":
					if (self::exists($key, "session")) {
						return Session::get($key);
					} else {
						if ($set_if_not_present) {
							self::set($key, $default_value, "session");
						}
						return $default_value;
					}
					break;
			}
		}
	}

	/**
	 *
	 * Guardar un valor
	 *
	 * $key: el nombre del valor
	 * $valor: el valor del key
	 * $mode: modo de almacenamiento del valor: db/cookie/session - default: db
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param string $mode
	 */
	public static function set($key, $value, $mode = "db") {
		if (!empty($key)) {
			switch ($mode) {
				case "db":
					if (self::exists($key)) {
						DB::update("appconfig")->value("value", $value)->where("key", $key)->execute();
					} else {
						DB::insert("appconfig")->set(array("key" => $key, "value" => $value))->execute();
					}
					break;
				case "cookie":
					Cookie::set($key, $value);
					break;
				case "session":
					Session::set($key, $value);
					break;
			}
		}
	}

	/**
	 *
	 * Chequea si un valor existe
	 *
	 * $key: el nombre del valor
	 * $mode: modo de almacenamiento del valor: db/cookie/session - default: db
	 *
	 * @param string $key
	 * @param string $mode
	 * @return boolean
	 */
	public static function exists($key, $mode = "db") {
		switch ($mode) {
			case "db":
				$response = DB::select()->from("appconfig")->where("key", $key)->execute();
				return(count($response) > 0 ? true : false);
				break;
			case "cookie":
				return Cookie::get($key);
				break;
			case "session":
				return Session::get($key);
				break;
		}
	}

	/**
	 *
	 * Borra un valor
	 *
	 * $key: el nombre del valor
	 * $mode: modo de almacenamiento del valor: db/cookie/session - default: db
	 *
	 * @param string $key
	 * @param string $mode
	 */
	public static function delete($key, $mode = "db") {
		if (!empty($key)) {
			switch ($mode) {
				case "db":
					DB::delete("appconfig")->where("key", $key)->execute();
					break;
				case "cookie":
					Cookie::delete($key);
					break;
				case "session":
					Session::delete($key);
					break;
			}
		}
	}

}
