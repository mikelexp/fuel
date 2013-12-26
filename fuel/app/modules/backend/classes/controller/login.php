<?

namespace Backend;

use Controller_Backend_Login;
use Fuel\Core\View;
use Fuel\Core\Validation;
use Fuel\Core\Response;
use Mkauth\Mkauth;

class Controller_Login extends Controller_Backend_Login {

	function action_index() {

		$val = Validation::forge();

		$val->add_model("Model_Validator");
		$val->add("usuario", "Usuario")->add_rule("required");
		$val->add("password", "Password")->add_rule("required")->add_rule("backend_login_check", $val);

		if ($val->run()) {
			if (Mkauth::login($val->validated("usuario"), $val->validated("password")))
				Response::redirect("backend");
		}

		$data['val'] = $val;

		$this->template->body = View::forge("login", $data);
		return $this->response();

	}

}
