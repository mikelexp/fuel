<?

namespace Backend;

use Fuel\Core\Config;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Mkemailqueue\Mkemailqueue;
use Mkemailqueue\Model_Mkemailqueue;
use Mkmessages\Mkmessages;
use Mkpagination\Mkpagination;

class Controller_Emails extends \Controller_Backend {

	function action_index() {
		Response::redirect("backend/emails/listar");
	}

	function action_listar() {

		// pagina
		$pagina = Input::get("pagina") ?: 1;
		$data['pagina'] = $pagina;

		// query
		$query = Model_Mkemailqueue::query();

		// busqueda
		$q = Input::get("q");
		if ($q) {
			$query->where_open();
			$query->where("subject", "like", "%{$q}%");
			$query->where_close();
		}
		$data['q'] = $q;

		// orden
		$query->order_by("fecha_creacion", "desc");

		// paginador
		$por_pagina = Config::get("paginadores_por_pagina");
		$rango = Config::get("paginadores_rango");
		$data['paginador'] = Mkpagination::get($query, $pagina, $por_pagina, $rango, Uri::create("backend/emails/listar?q={$q}&pagina=%s"));

		// get
		$items = $query->get();
		$data['items'] = $items;

		$this->template->body = View::forge("emails_listar", $data);
		return $this->response();

	}

	function action_ver($id) {

		$eq = Model_Mkemailqueue::query()->where("id", $id)->get_one();
		$body = $eq->message_html ?: $eq->message_plain;

		return Response::forge($body, 200, array("Content-Type" => "text/html; charset=utf-8"));

	}

	function action_enviar() {

		Mkemailqueue::forge()->send();
		Mkmessages::add("Los emails pendientes han sido enviados.");
		Response::redirect("backend/emails/listar");

	}

}
