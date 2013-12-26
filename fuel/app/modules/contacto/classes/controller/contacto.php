<?

namespace Contacto;

use Controller_Frontend;
use Fuel\Core\Validation;
use Fuel\Core\View;

class Controller_Contacto extends Controller_Frontend {

	public function action_index() {

		$val = Validation::forge();

		$val->add("nombre", "Nombre")->add_rule("required");
		$val->add("mensaje", "Mensaje")->add_rule("required");

		if ($val->run()) {
			$this->template->body = View::forge("ok");
			return $this->response($this->template);
		}

		$data['val'] = $val;
	
		$this->template->body = View::forge("index", $data);
		return $this->response();

	}

}
