<?

namespace Backend;

use Fuel\Core\Config;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Upload;
use Fuel\Core\Uri;
use Fuel\Core\Validation;
use Fuel\Core\View;
use Mkmessages\Mkmessages;
use Mkpagination\Mkpagination;
use Model_Categoria;
use Model_Producto;

class Controller_Productos extends Controller_Backend {

	function action_index() {
		Response::redirect("backend/productos/listar");
	}

	function action_listar() {

		// pagina
		$pagina = Input::get("pagina") ?: 1;
		$data['pagina'] = $pagina;

		// query
		$query = \Model_Producto::query();
		$query->related("categoria");

		// busqueda
		$q = Input::get("q");
		if ($q) {
			$query->where_open();
			$query->where("nombre", "like", "%{$q}%");
			$query->or_where("categoria.nombre", "like", "%{$q}%");
			$query->where_close();
		}
		$data['q'] = $q;

		// orden
		$query->order_by("categoria.nombre");
		$query->order_by("nombre");

		// paginador
		$por_pagina = Config::get("paginadores_por_pagina");
		$rango = Config::get("paginadores_rango");
		$data['paginador'] = Mkpagination::get($query, $pagina, $por_pagina, $rango, Uri::create("backend/admins/listar?q={$q}&pagina=%s"));

		// get
		$items = $query->get();
		$data['items'] = $items;

		$this->template->body = View::forge("productos_listar", $data);
		return $this->response();

	}

	function action_procesar($id = "") {

		$item = $id ? Model_Producto::find($id) : Model_Producto::forge();
		$mode = $id ? "m" : "a";

		// checks
		if ($mode == "m" && !$item) {
			Mkmessages::add("El ítem a modificar no existe");
			Response::redirect("backend/productos/listar");
		}

		// defaults
		if (Input::method() == "GET" && $mode == "a")
			$item->activo = true;

		// fecha
		if ($mode == "m") {
			$fecha = date_parse($item->fecha);
			$item->fecha = "{$fecha['day']}/{$fecha['month']}/{$fecha['year']}";
			$item->fecha_hora = $fecha['hour'];
			$item->fecha_minuto = $fecha['minute'];
			$item->fecha_segundo = $fecha['second'];
		} else {
			$item->fecha = date("d/m/Y");
			$item->fecha_hora = date("H");
			$item->fecha_minuto = date("i");
			$item->fecha_segundo = date("s");
		}

		// validation
		$val = Validation::forge();
		$val->add_model("Model_Validator");
		$val->add_field("categoria", "Categoría", "trim|required|valid_string[numeric]");
		$val->add_field("nombre", "Nombre", "trim|required");
		$val->add_field("descripcion", "Descripción", "trim");
		$val->add_field("fecha", "Fecha", "trim|required");
		$val->add_field("fecha_hora", "Fecha/Hora", "trim|required|valid_string[numeric]");
		$val->add_field("fecha_minuto", "Fecha/Minutos", "trim|required|valid_string[numeric]");
		$val->add_field("fecha_segundo", "Fecha/Segundos", "trim|required|valid_string[numeric]");
		$val->add_field("foto", "Foto", "subir_archivo[{$item->foto},required]");
		$val->add_field("activo", "Activo", "valid_string[numeric]");

		// upload
		if (Input::method() == "POST") {
			Upload::process(array(
				"ext_whitelist" => array("jpg", "jpeg", "png", "gif"),
			));
			if (Upload::is_valid())
				Upload::save();
		}

		if ($val->run()) {
			$item->categoria_id = $val->validated("categoria");
			$item->nombre = $val->validated("nombre");
			$item->descripcion = $val->validated("descripcion");
			list($fecha_dia, $fecha_mes, $fecha_ano) = explode("/", $val->validated("fecha"));
			$fecha_hora = $val->validated("fecha_hora");
			$fecha_minuto = $val->validated("fecha_minuto");
			$fecha_segundo = $val->validated("fecha_segundo");
			$item->fecha = "{$fecha_ano}/{$fecha_mes}/{$fecha_dia} {$fecha_hora}:{$fecha_minuto}:{$fecha_segundo}";
			$item->foto = $val->validated("foto");
			$item->activo = $val->validated("activo");
			$item->save();
			Model_Producto::procesar_imagenes($item);
			Mkmessages::add("El producto <strong>{$item->nombre}</strong> ha sido ".($mode == "a" ? "creado" : "modificado").".");
			Response::redirect("backend/productos/listar");
		}

		// categorias
		$categorias_query = Model_Categoria::query();
		$categorias = $categorias_query->order_by("orden")->get();
		$data['categorias'] = $categorias;

		$data['mode'] = $mode;
		$data['val'] = $val;
		$data['item'] = $item;
		$data['titulo'] = $mode == "a" ? "Agregar producto" : "Modificar producto: {$item->nombre}";
		$data['form_post'] = "backend/productos/procesar/{$id}";

		$this->template->body = View::forge("productos_form", $data);
		return $this->response();

	}

	function action_borrar($id = null) {

		$item = \Model_Producto::find($id);
		if (!$item) {
			Mkmessages::add("El producto a eliminar no existe.", "error");
		} else {
			$item->delete();
			Mkmessages::add("El producto <strong>{$item->nombre}</strong> ha sido eliminado.");
		}
		Response::redirect("backend/productos/listar");

	}

}
