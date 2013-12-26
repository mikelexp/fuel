<?

use Fuel\Core\Controller;
use Fuel\Core\Request;

class Controller_Widgets extends Controller {

	public function before() {

		parent::before();

		if (!Request::is_hmvc())
			exit("");

	}

}
