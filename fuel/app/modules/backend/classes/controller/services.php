<?

namespace Backend;

use Controller_Backend_Services;
use Fuel\Core\Input;
use Model_Admin;
use Model_Categoria;
use Model_Producto;

class Controller_Services extends Controller_Backend_Services {

	function post_update() {

		$data = explode("_", Input::post("data"));

		try {
			switch ($data[0]) {
				case "admin":
					switch ($data[1]) {
						case "activar":
							Model_Admin::activar($data[2]);
							break;
					}
					break;
				case "producto":
					switch ($data[1]) {
						case "activar":
							Model_Producto::activar($data[2]);
							break;
					}
					break;
				case "categoria":
					switch ($data[1]) {
						case "activar":
							Model_Categoria::activar($data[2]);
							break;
					}
					break;
			}
			return $this->response_json($this->ok());
		} catch (\Exception $ex) {
			return $this->response_json($this->error($ex->getMessage()));
		}

	}

	private function ok() {
		return json_encode(array(
			"status" => "ok"
		));
	}

	private function error($error = "") {
		return json_encode(array(
			"status" => "error",
			"error" => $error
		));
	}

}
