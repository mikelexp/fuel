<?

namespace Facebook;

use Controller_Frontend_Facebook;
use Fuel\Core\Debug;
use Fuel\Core\Validation;
use Fuel\Core\View;

class Controller_Facebook extends Controller_Frontend_Facebook {

	function action_index() {

		$data['facebook_user_id'] = $this->facebook_user_id;
		$data['facebook_user'] = $this->facebook_user;
		$data['login_url'] = $this->facebook_login_url;
		$data['logout_url'] = $this->facebook_logout_url;

		$this->template->body = View::forge("facebook", $data);
		return $this->response();

	}

	function action_friends() {

		$friends = $this->facebook->api("/me/friends");
		$data['friends'] = $friends;

		$this->template->body = View::forge("friends", $data);
		return $this->response();

	}

	function action_friends_fql() {

		$friends = $this->facebook->api(array(
			"method" => "fql.query",
			"query" => "SELECT uid1, uid2 FROM friend WHERE uid1 = ".$this->facebook->getUser()
		));
		$data['friends'] = $friends;

		$this->template->body = View::forge("friends_fql", $data);
		return $this->response();

	}

	function action_post() {

		$val = Validation::forge();

		$val->add_field("mensaje", "Mensaje", "trim|required");

		if ($val->run()) {
			try {
				$post_result = $this->facebook->api("/me/feed", "POST", array(
					"message" => $val->validated("mensaje")
				));
				$data['post_id'] = $post_result['id'];
			} catch (\FacebookApiException $ex) {
				Debug::dump($ex);
			}
		}

		$data['val'] = $val;
		$this->template->body = View::forge("post", $data);
		return $this->response();

	}

}
