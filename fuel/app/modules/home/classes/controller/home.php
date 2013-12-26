<?

namespace Home;

use Controller_Frontend;
use Fuel\Core\View;

class Controller_Home extends Controller_Frontend {

	public function action_index() {
		$this->template->body = View::forge("index");
		return $this->response();
	}

}
