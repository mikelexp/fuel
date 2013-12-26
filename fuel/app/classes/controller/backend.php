<?

use Fuel\Core\Asset;
use Fuel\Core\View;
use Fuel\Core\Response;
use Fuel\Core\Html;
use Fuel\Core\Config;
use Mkauth\Mkauth;

class Controller_Backend extends Controller_Base {

	public function before() {

		parent::before();

		// config
		Config::load("backend");

		// mkauth
		Mkauth::initialize("mkauth_backend");
		if (!Mkauth::is_logged())
			Response::redirect("backend/login");

		// template
		$this->template = View::forge("template");

		// template items
		$this->template->doctype = Html::doctype("html5");
		$this->template->title = "The Ultimate FuelPHP Setup";
		$this->template->meta_keywords = Html::meta("keywords", "keywords");
		$this->template->meta_description = Html::meta("description", "description");

		// assets path
		Asset::add_path("assets/backend");
		Asset::add_path("assets/frontend/swf", "swf");

		// jquery
		Asset::js("jquery/jquery-1.7.2.min.js");

		// twitter bootstrap
		Asset::css("bootstrap/css/bootstrap.css");
		Asset::js("bootstrap/bootstrap.js");

		// base css
		Asset::css("base.css");

		// custom js
		Asset::js("code.js");

		// swfobject
		Asset::js("swfobject/swfobject.js");

		// mk select updater
		Asset::js("jquery.mk_select_updater/mk_select_updater.js");

		// ckeditor
		Asset::js("ckeditor/ckeditor.js");
		Asset::js("ckeditor/adapters/jquery.js");
		Asset::js("ckeditor.startup/ckeditor.js");

		// bootstrap datepicker
		Asset::js("bootstrap.datepicker/css/datepicker.css");
		Asset::js("bootstrap.datepicker/js/bootstrap-datepicker.js");
		Asset::js("bootstrap.datepicker/js/locales/bootstrap-datepicker.es.js");

		// autosize
		Asset::js("jquery.autosize/jquery.autosize.js");

		// colorbox
		Asset::js("jquery.colorbox/colorbox/jquery.colorbox-min.js");
		Asset::css("colorbox/example1/colorbox.css");

		// default value
		Asset::js("jquery.defaultvalue/jquery.defaultvalue.js");

		// jquery tools
		Asset::js("jquery.jquerytools/jquery.tools.min.js");

		// lazy load
		Asset::js("jquery.lazyload/jquery.lazyload.min.js");

		// chosen
		Asset::css("chosen/chosen.css");
		Asset::js("jquery.chosen/chosen.jquery.min.js");

	}

}
