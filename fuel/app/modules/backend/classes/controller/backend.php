<?

namespace Backend;

use Fuel\Core\View;
use Mkauth\Mkauth;
use Fuel\Core\Response;

class Controller_Backend extends \Controller_Backend {

	public function action_index() {

		$this->template->body = View::forge("index");
		return $this->response();

	}

	public function action_logout() {

		Mkauth::logout();
		Response::redirect("backend/login");

	}

}
