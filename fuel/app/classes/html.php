<?

class Html extends Fuel\Core\Html {

	public static function img_asset($img_file, $attrs = array()) {
		return Html::img(Asset::find_file($img_file, "img"), $attrs);
	}

}
