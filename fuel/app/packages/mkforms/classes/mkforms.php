<?

namespace Mkforms;

use Fuel\Core\Form;
use Fuel\Core\Input;
use Fuel\Core\Validation;

class Mkforms {

	public static function set_value(Validation &$val = null, $field = "", $default = "") {

		if (!$val) {
			// no hay objeto validation, usar post
			if (!Input::post($field)) {
				// no hay post, usar default
				return $default;
			} else {
				// hay post, devolver valor de post
				return Form::prep_value(Input::post($field));
			}
		} else if (Input::method() == "POST") {
			// hay validation y hay post, devolver valor validado
			return Form::prep_value($val->validated($field));
		} else {
			// hay validacion pero no post, devolver default
			return $default;
		}

	}

	public static function set_checkbox(Validation &$val = null, $field = "", $value = "", $default = false) {

		$check = false;

		if (!$val) {
			// no hay validacion, usar post
			if (!Input::post($field)) {
				// no hay post, usar default
				$check = $default;
			} else {
				// hay post, usarlo
				if (Input::post($field) == $value) {
					$check = true;
				}
			}
		} else if (Input::method() == "POST") {
			// hay validacion y hay post, usar validacion
			if ($val->validated($field) == $value) {
				$check = true;
			}
		} else {
			// hay validacion pero no hay post, usar default
			$check = $default;
		}

		return $check ? ' checked="checked"' : '';

	}

	public static function set_radio(Validation &$val = null, $field = "", $value = "", $default = false) {

		$select = false;

		if (!$val) {
			// no hay validacion, usar post
			if (!Input::post($field)) {
				// no hay post, usar default
				$select = $default;
			} else {
				// hay post, usarlo
				if (Input::post($field) == $value) {
					$select = true;
				}
			}
		} else if (Input::method() == "POST") {
			// hay validacion y hay post, usar validacion
			if ($val->validated($field) == $value) {
				$select = true;
			}
		} else {
			// hay validacion pero no hay post, usar default
			$select = $default;
		}

		return $select ? ' selected="selected"' : '';

	}

	public static function set_select(Validation &$val = null, $field = "", $value = "", $default = false) {

		$select = false;

		if (!$val) {
			// no hay validacion, usar post
			if (!Input::post($field)) {
				// no hay post, usar default
				$select = $default;
			} else {
				// hay post, usarlo
				if (Input::post($field) == $value) {
					$select = true;
				}
			}
		} else if (Input::method() == "POST") {
			// hay validacion y hay post, usar validacion
			if ($val->validated($field) == $value) {
				$select = true;
			}
		} else {
			// hay validacion pero no hay post, usar default
			$select = $default;
		}

		return $select ? ' selected="selected"' : '';
		
	}

}
