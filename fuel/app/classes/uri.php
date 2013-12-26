<?

class Uri extends Fuel\Core\Uri {

	public static function prep_url($str) {
		if ($str == "http://" || $str == "") {
			return "";
		}
		$url = parse_url($str);
		if (!$url || !isset($url['scheme'])) {
			$str = "http://{$str}";
		}
		return $str;
	}

}
