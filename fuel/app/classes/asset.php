<?

use Fuel\Core\Uri;

class Asset extends Fuel\Core\Asset {

	public static function upload($file_path) {
		return Uri::create("uploads/".$file_path);
	}

	public static function less($less_file) {
		return Asset::css(Uri::create("less/get")."?path=".urlencode(Asset::find_file($less_file, "css")));
	}

	public static function swf($swf_file) {
		return Uri::create(Asset::find_file($swf_file, "swf"));
	}

	public static function find_img($img_file) {
		return Uri::create(Asset::find_file($img_file, "img"));
	}

}
