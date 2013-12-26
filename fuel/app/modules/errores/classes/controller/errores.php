<?

namespace Errores;

use Controller_Frontend;
use Fuel\Core\View;

class Controller_Errores extends Controller_Frontend {

	public function action_404() {
		$this->template->body = View::forge("404");
		return $this->response(404);
	}

}
