<?

namespace Backend;

use Fuel\Core\Config;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Uri;
use Fuel\Core\Validation;
use Fuel\Core\View;
use Mkauth\Mkauth;
use Mkmessages\Mkmessages;
use Mkpagination\Mkpagination;

class Controller_Admins extends \Controller_Backend {

	function action_index() {
		Response::redirect("backend/admins/listar");
	}

	function action_listar() {

		// pagina
		$pagina = Input::get("pagina") ?: 1;
		$data['pagina'] = $pagina;

		// query
		$query = \Model_Admin::query();

		// busqueda
		$q = Input::get("q");
		if ($q) {
			$query->where("usuario", "like", "%{$q}%");
			$query->or_where("nombre", "like", "%{$q}%");
			$query->or_where("email", "like", "%{$q}%");
		}
		$data['q'] = $q;

		// orden
		$query->order_by("nombre");

		// paginador
		$por_pagina = Config::get("paginadores_por_pagina");
		$rango = Config::get("paginadores_rango");
		$data['paginador'] = Mkpagination::get($query, $pagina, $por_pagina, $rango, Uri::create("backend/admins/listar?q={$q}&pagina=%s"));

		// get
		$items = $query->get();
		$data['items'] = $items;

		$this->template->body = View::forge("admins_listar", $data);
		return $this->response();

	}

	function action_procesar($id = "") {

		$item = $id ? \Model_Admin::find($id) : \Model_Admin::forge();
		$mode = $id ? "m" : "a";

		// checks
		if ($mode == "m" && !$item) {
			Mkmessages::add("El ítem a modificar no existe");
			Response::redirect("backend/admins/listar");
		}

		// defaults
		if (Input::method() == "GET" && $mode == "a")
			$item->activo = true;

		// validation
		$val = Validation::forge();
		$val->add_field("nombre", "Nombre", "trim|required");
		$val->add_field("usuario", "Usuario", "trim|required");
		if ($mode == "a")
			$val->add_field("password", "Contraseña", "trim|required");
		else
			$val->add_field("password", "Contraseña", "trim");
		$val->add_field("email", "Email", "trim|required|valid_email");
		$val->add_field("activo", "Activo", "valid_string[numeric]");

		if ($val->run()) {
			$item->nombre = $val->validated("nombre");
			$item->usuario = $val->validated("usuario");
			if ($val->validated("password"))
				$item->password = Mkauth::hash_password($val->validated("password"));
			$item->email = $val->validated("email");
			$item->activo = $val->validated("activo");
			$item->save();
			Mkmessages::add("El administrador <strong>{$item->usuario}</strong> ha sido ".($mode == "a" ? "creado" : "modificado").".");
			Response::redirect("backend/admins/listar");
		}

		$data['mode'] = $mode;
		$data['val'] = $val;
		$data['item'] = $item;
		$data['titulo'] = $mode == "a" ? "Agregar administrador" : "Modificar administrador: {$item->usuario}";
		$data['form_post'] = "backend/admins/procesar/{$id}";

		$this->template->body = View::forge("admins_form", $data);
		return $this->response();

	}

	function action_borrar($id = null) {

		$item = \Model_Admin::find($id);
		if (!$item) {
			Mkmessages::add("El administrador a eliminar no existe.", "error");
		} else {
			$item->delete();
			Mkmessages::add("El administrador <strong>{$item->nombre}</strong> ha sido eliminado.");
		}
		Response::redirect("backend/admins/listar");

	}

}
