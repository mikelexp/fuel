<?

namespace Mkbrowserphp;

use Fuel\Core\Agent;
use Fuel\Core\Config;
use Fuel\Core\Fuel;

class Mkbrowserphp {

	private static $browser;
	private static $firephp;
	private static $chromephp;
	private static $CI;
	private static $enabled;
	private static $environments;

	public static function _init() {

		// configuracion
		Config::load("mkbrowserphp", true, true, true);
		static::$enabled = Config::get("mkbrowserphp.enabled");
		if (!is_bool(static::$enabled))
			static::$enabled = false;
		static::$environments = Config::get("mkbrowserphp.environments");
		if (!is_array(static::$environments))
			static::$environments = array(static::$environments);

		// desactivar si no coincide el environment
		if (static::$enabled && !in_array(Fuel::$env, static::$environments))
			static::$enabled = false;

		// deteccion de browser y creacion de instancia de firephp o chromephp
		if (static::$enabled) {
			switch (strtolower(Agent::browser())) {
				case "firefox":
					static::$browser = "firefox";
					static::$firephp = new \FirePHP;
					break;
				case "chrome":
				case "chromium":
					static::$browser = "chrome";
					static::$chromephp = new \ChromePhp;
					break;
			}
		}

	}

	private static function is_firefox() {
		return (static::$browser == "firefox");
	}

	private static function is_chrome() {
		return (static::$browser == "chrome");
	}

	/**
	 * Loggea un valor
	 *
	 * @param mixed $value
	 * @param string $label
	 */
	public static function log($value, $label = null) {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->log($value, $label);
			} else if (self::is_chrome()) {
				static::$chromephp->log($label, $value);
			}
		}
	}

	/**
	 * Loggea un valor de tipo WARN
	 *
	 * @param mixed $value
	 * @param string $label
	 */
	public static function warn($value, $label = null) {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->warn($value, $label);
			} else if (self::is_chrome()) {
				static::$chromephp->warn($label, $value);
			}
		}
	}

	/**
	 * Loggea un valor de tipo ERROR
	 *
	 * @param mixed $value
	 * @param string $label
	 */
	public static function error($value, $label = null) {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->error($value, $label);
			} else if (self::is_chrome()) {
				static::$chromephp->error($label, $value);
			}
		}
	}

	/**
	 * Loggea un valor de tipo INFO
	 *
	 * @param mixed $value
	 * @param string $label
	 */
	public static function info($value, $label = null) {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->info($value, $label);
			} else if (self::is_chrome()) {
				static::$chromephp->info($label, $value);
			}
		}
	}

	/**
	 * Inicia un grupo de valores
	 *
	 * @param string $group_name
	 */
	public static function group_start($group_name) {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->group($group_name);
			} else if (self::is_chrome()) {
				static::$chromephp->group($group_name);
			}
		}
	}

	/**
	 * Inicia un grupo de valores colapsado
	 *
	 * @param string $group_name
	 */
	public static function group_start_collapsed($group_name) {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->group($group_name, array("Collapsed" => true));
			} else if (self::is_chrome()) {
				static::$chromephp->groupCollapsed($group_name);
			}
		}
	}

	/**
	 * Finaliza el ultimo grupo de valores iniciado
	 */
	public static function group_end() {
		if (static::$enabled) {
			if (self::is_firefox()) {
				static::$firephp->groupEnd();
			} else if (self::is_chrome()) {
				static::$chromephp->groupEnd();
			}
		}
	}


}
