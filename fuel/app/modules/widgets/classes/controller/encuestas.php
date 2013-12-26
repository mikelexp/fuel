<?

namespace Widgets;

use Controller_Widgets;
use Fuel\Core\View;

class Controller_Encuestas extends Controller_Widgets {

	public function action_get() {
		return View::forge("encuestas");
	}

}
