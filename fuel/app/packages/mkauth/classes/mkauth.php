<?

namespace Mkauth;

use Fuel\Core\FuelException;
use Fuel\Core\Session;
use Fuel\Core\Config;
use PHPSecLib\Crypt_Hash;

class Mkauth {

	private static $model_name;
	private static $username_field;
	private static $password_field;
	private static $session_variable;
	private static $password_salt;

	public static function initialize($config = "mkauth") {
		Config::load($config, "mkauth", true, true);
		static::$model_name = Config::get("mkauth.model_name");
		static::$username_field = Config::get("mkauth.username_field");
		static::$password_field = Config::get("mkauth.password_field");
		static::$session_variable = Config::get("mkauth.session_variable");
		static::$password_salt = Config::get("mkauth.password_salt");
	}

	public static function login($username = "", $password = "") {
		
		$username = trim($username);
		$password = trim($password);

		if (!$username || !$password)
			throw new MkauthException("No se especificaron los datos necesarios para el login");

		$model = new static::$model_name;

		$usuario = $model->query()
				->where(static::$username_field, $username)
				->where(static::$password_field, self::hash_password($password))
				->get_one();

		if (count($usuario) > 0) {
			Session::set(static::$session_variable, $usuario->id);
			return $usuario;
		} else {
			return false;
		}

	}

	public static function logout() {
		Session::delete(static::$session_variable);
	}

	public static function is_logged() {
		return Session::get(static::$session_variable) !== null ? true : false;
	}

	public static function get_user() {
		if (!self::is_logged())
			return null;
		$model = new static::$model_name;
		$usuario = $model->query()
				->where("id", Session::get(static::$session_variable))
				->get_one();
		if (count($usuario) > 0)
			return $usuario;
		self::logout();
		return null;
	}

	public static function hash_password($password) {
		$hasher = new Crypt_Hash;
		return base64_encode($hasher->pbkdf2($password, static::$password_salt, 10000, 32));
	}

	public static function create_password($length = 8, $alphabet = "") {
		$alphabet = $alphabet ?: "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$alphabet_length = strlen($alphabet) - 1; //put the length -1 in cache
		$password = "";
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphabet_length);
			$password .= $alphabet[$n];
		}
		return $password;
	}

}

class MkauthException extends FuelException {

}
