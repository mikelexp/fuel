<?

use Fuel\Core\Controller;
use Fuel\Core\Response;
use Mkautocreate\Mkautocreate;

class Controller_Base extends Controller {

	public $template;

	public function before() {

		parent::before();

		// mkautocreate
		Mkautocreate::run();

	}

	public function response($status = 200) {

		$response = new Response;
		$response->body($this->template);
		$response->set_status($status);
		$response->set_header("Content-Type", "text/html; charset=utf-8");
		return $response;

		/* o lo que es lo mismo...
		return Response::forge($this->template, $status, array("Content-Type" => "text/html; charset=utf-8"));
		*/

	}

}
