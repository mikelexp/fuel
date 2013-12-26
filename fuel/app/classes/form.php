<?

class Form extends \Fuel\Core\Form {

	public static function open_multipart($attributes = array(), array $hidden = array()) {
		$attributes["enctype"] = "multipart/form-data";
		return parent::open($attributes, $hidden);
	}

}
