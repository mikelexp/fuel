<?

namespace Productos;

use Controller_Frontend;
use Fuel\Core\Response;
use Fuel\Core\View;
use Model_Producto;

class Controller_Productos extends Controller_Frontend {

	public function action_index() {

		$productos = Model_Producto::find('all');
		$data['productos'] = $productos;

		$this->template->body = View::forge("index", $data);
		return $this->response();

	}

	public function action_ver($id) {

		$producto = Model_Producto::find($id);

		if (!$producto)
			Response::redirect("productos");

		$data['producto'] = $producto;

		$this->template->body = View::forge("ver", $data);
		return $this->response();

	}

}
