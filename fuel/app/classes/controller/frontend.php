<?

use Fuel\Core\Asset;
use Fuel\Core\Config;
use Fuel\Core\Html;
use Fuel\Core\View;
use Mkauth\Mkauth;

class Controller_Frontend extends Controller_Base {

	public function before() {

		parent::before();

		// config
		Config::load("frontend");

		// mkauth
		Mkauth::initialize("mkauth_frontend");

		// template
		$this->template = View::forge("templates/base");

		// template items
		$this->template->doctype = Html::doctype("html5");
		$this->template->title = "The Ultimate FuelPHP Setup";
		$this->template->meta_keywords = Html::meta("keywords", "keywords");
		$this->template->meta_description = Html::meta("description", "description");

		// assets
		Asset::add_path("assets/frontend");
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

		// widgets css
		Asset::css("widgets.css");

		// swfobject
		Asset::js("swfobject/swfobject.js");

		// mk select updater
		Asset::js("jquery.mk_select_updater/mk_select_updater.js");

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

	}

}
