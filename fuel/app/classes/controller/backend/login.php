<?

use Fuel\Core\Html;
use Fuel\Core\View;
use Fuel\Core\Asset;
use Mkauth\Mkauth;

class Controller_Backend_Login extends Controller_Base {

	public function before() {

		parent::before();

		// mkauth
		Mkauth::initialize("mkauth_backend");

		// template
		$this->template = View::forge("template_login");

		// template items
		$this->template->doctype = Html::doctype("html5");
		$this->template->title = "The Ultimate FuelPHP Setup";
		$this->template->meta_keywords = Html::meta("keywords", "keywords");
		$this->template->meta_description = Html::meta("description", "description");

		// assets path
		Asset::add_path("assets/backend");

		// jquery
		Asset::js("jquery/jquery-1.7.2.min.js");

		// twitter bootstrap
		Asset::css("bootstrap/css/bootstrap.css");
		Asset::js("bootstrap/bootstrap.js");

		// login css
		Asset::css("login.css");

		// custom js
		Asset::js("login.js");

	}

}
