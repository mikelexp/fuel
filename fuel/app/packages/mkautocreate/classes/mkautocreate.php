<?

namespace Mkautocreate;

use Fuel\Core\Config;
use Fuel\Core\File;
use Log;

class Mkautocreate {

	static private $create;
	static private $set_permissions;
	static private $basepath;
	static private $dirs;
	static private $permissions;

	public static function _init() {
		Config::load("mkautocreate", true, true, true);
		static::$basepath = Config::get("mkautocreate.basepath");
		static::$dirs = Config::get("mkautocreate.dirs");
		static::$create = Config::get("mkautocreate.create");
		static::$set_permissions = Config::get("mkautocreate.set_permissions");
		static::$permissions = Config::get("mkautocreate.permissions");
	}

	/**
	 * Ejecuta la autocreacion y seteo de permisos
	 */
	public static function run() {
		if (static::$create || static::$set_permissions) {
			if (!is_array(static::$dirs) && static::$dirs)
				static::$dirs = array(static::$dirs);
			if (count(static::$dirs) > 0) {
				foreach (static::$dirs as $dir) {
					if (!is_dir(static::$basepath.$dir) && static::$create)
						try {
							File::create_dir(static::$basepath, $dir, static::$permissions);
							Log::info("Mkautocreate: creado ".static::$basepath.$dir);
						} catch (\InvalidPathException $ex) {
							Log::error("Mkautocreate: ".$ex->getCode()." - ".$ex->getMessage());
						} catch (\FileAccessException $ex) {
							Log::error("Mkautocreate: ".$ex->getCode()." - ".$ex->getMessage());
						}
					if (is_dir(static::$basepath.$dir) && static::$set_permissions)
						@chmod(static::$basepath.$dir, static::$permissions);
				}
			}
		}
	}

}
