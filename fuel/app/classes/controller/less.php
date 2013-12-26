<?

use Fuel\Core\Input;
use Fuel\Core\Response;

class Controller_Less extends Controller_Frontend {

	public function action_get() {
		$path = Input::get("path");
		$less = new \lessc();
		return Response::forge(
			$less->compileFile(DOCROOT.$path),
			200,
			array("Content-Type" => "text/css")
		);
	}

}
