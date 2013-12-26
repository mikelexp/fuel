<?

use Fuel\Core\Controller_Rest;
use Fuel\Core\Response;
use Mkauth\Mkauth;

class Controller_Backend_Services extends Controller_Rest {

	public function before() {
		parent::before();
		// mkauth
		Mkauth::initialize("mkauth_backend");
	}

	public function response_json($json_data) {
		if (!Mkauth::is_logged()) {
			$error = array(
				"error" => "Su sesión ha finalizado"
			);
			return Response::forge(json_encode($error), 200, array("Content-Type" => "application/json"));
		}
		return Response::forge($json_data, 200, array("Content-Type" => "application/json"));
	}

	public function response_xml($xml_data) {
		if (!Mkauth::is_logged()) {
			// inventar algun modo de responder por xml que no hay usuario logueado
		}
		return Response::forge($xml_data, 200, array("Content-Type" => "application/xml"));
	}

}
