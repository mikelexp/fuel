<?

use Fuel\Core\FuelException;
use Fuel\Core\Lang;
use Fuel\Core\Upload;
use Fuel\Core\Validation;
use Mkauth\Mkauth;

class Model_Validator extends Fuel\Core\Model {

	public static function _validation_backend_login_check($value, Validation $val) {

		Validation::active()->set_message("backend_login_check", "Los datos ingresados son incorrectos");

		if (Mkauth::login($val->input("usuario"), $val->input("password")))
			return true;
		else
			return false;

	}

	public static function _validation_subir_archivo($value, $current_file = "", $required = "") {

		$val = Validation::active();
		$field_name = $val->active_field()->name;
		$rule_name = "subir_archivo";
		Lang::load("validation", true, true);

		// primero chequeo si hay error de upload
		$error = Upload::get_errors($field_name);
		if (isset($error['errors'])) {
			switch ($error['errors'][0]['error']) {
				case Upload::UPLOAD_ERR_NO_FILE:
					if (empty($current_file) && $required == "required") {
						// error: no subieron archivos, no hay archivo anterior y el campo es obligatorio
						$val->set_message($rule_name, Lang::get("validation.required"));
						return false;
					}
					break;
				default:
					// error: algo fallo al procesar el upload (filtro de extensiones, etc)
					$val->set_message($rule_name, $error['errors'][0]['message']);
					return false;
			}
		}

		// el upload funciono, ahora determinar el nombre del archivo a devolver
		try {
			$file = Upload::get_files($field_name);
			if ($file && isset($file['saved_as'])) {
				// subieron un archivo, lo devuelvo
				return $file['saved_as'];
			} else if (!empty($current_file)) {
				// no subieron un archivo pero hay archivo anterior, lo devuelvo
				return $current_file;
			}
		} catch (FuelException $ex) {
			// algun otro error
			$val->set_message($rule_name, $ex->getMessage());
			return false;
		}

	}

}
