<?

use Fuel\Core\Config;
use Fuel\Core\Response;

/**
 * @property \Facebook $facebook
 */

class Controller_Frontend_Facebook extends Controller_Frontend {

	protected $facebook;
	protected $facebook_user_id;
	protected $facebook_user;
	protected $facebook_scope;
	protected $facebook_login_url;
	protected $facebook_logout_url;

	public function before() {

		parent::before();

		Config::load("facebook", true, true, true);

		// creo la sesion facebook
		$this->facebook = new \Facebook(array(
			"appId" => Config::get("facebook.appId"),
			"secret" => Config::get("facebook.secret"),
			"fileUpload" => true,
		));

		// levanto el scope
		$this->facebook_scope = Config::get("facebook.scope");

		// levanto el usuario logueado
		$this->facebook_user_id = $this->facebook->getUser();

		// login url
		$this->facebook_login_url = $this->facebook->getLoginUrl(array(
			"scope" => implode(", ", $this->facebook_scope)
		));

		// logout url
		$this->facebook_logout_url = $this->facebook->getLogoutUrl();

		// intento obtener el perfil del usuario logueado, si falla lo mando al dialogo de facebook
		if ($this->facebook_user_id) {
			try {
				$this->facebook_user = $this->facebook->api("me");
			} catch (\FacebookApiException $ex) {
				$this->facebook_user_id = null;
				$this->facebook_user = null;
			}
		} else {
			Response::redirect($this->facebook_login_url);
		}

	}

}
