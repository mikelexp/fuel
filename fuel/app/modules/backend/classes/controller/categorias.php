<?

namespace Backend;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Validation;
use Fuel\Core\View;
use Mkmessages\Mkmessages;
use Model_Categoria;

class Controller_Categorias extends \Controller_Backend {

	function action_index() {
		Response::redirect("backend/categorias/listar");
	}

	function action_listar() {

		// query
		$query = Model_Categoria::query();

		// orden
		$query->order_by("orden");

		// get
		$items = $query->get();
		$data['items'] = $items;

		$this->template->body = View::forge("categorias_listar", $data);
		return $this->response();

	}

	function action_procesar($id = "") {

		$item = $id ? Model_Categoria::find($id) : Model_Categoria::forge();
		$mode = $id ? "m" : "a";

		// checks
		if ($mode == "m" && !$item) {
			Mkmessages::add("El ítem a modificar no existe");
			Response::redirect("backend/categorias/listar");
		}

		// defaults
		if (Input::method() == "GET" && $mode == "a")
			$item->activo = true;

		// validation
		$val = Validation::forge();
		$val->add_field("nombre", "Nombre", "trim|required");
		$val->add_field("activo", "Activo", "valid_string[numeric]");

		if ($val->run()) {
			$item->nombre = $val->validated("nombre");
			$item->activo = $val->validated("activo");
			if ($mode == "a")
				$item->orden = Model_Categoria::query()->max("orden") + 1;
			$item->save();
			Mkmessages::add("La categoría <strong>{$item->nombre}</strong> ha sido ".($mode == "a" ? "creada" : "modificada").".");
			Response::redirect("backend/categorias/listar");
		}

		$data['mode'] = $mode;
		$data['val'] = $val;
		$data['item'] = $item;
		$data['titulo'] = $mode == "a" ? "Agregar categoría" : "Modificar categoría: {$item->nombre}";
		$data['form_post'] = "backend/categorias/procesar/{$id}";

		$this->template->body = View::forge("categorias_form", $data);
		return $this->response();

	}

	function action_borrar($id = null) {

		$item = Model_Categoria::find($id);
		if (!$item) {
			Mkmessages::add("La categoría a eliminar no existe.", "error");
		} else {
			$item->delete();
			Mkmessages::add("La categoría <strong>{$item->nombre}</strong> ha sido eliminada.");
		}
		Response::redirect("backend/categorias/listar");

	}

	function action_mover($direccion, $categoria_id, $ubicacion_actual) {

		$categoria = Model_Categoria::find($categoria_id);

		$nueva_ubicacion = ($direccion == "subir") ? $ubicacion_actual - 1 : $ubicacion_actual + 1;

		$categoria->orden = $nueva_ubicacion;
		$categoria->save();

		$categorias = Model_Categoria::query()
				->where("id", "!=", $categoria->id)
				->order_by("orden")
				->get();

		$ubicacion = 1;

		foreach ($categorias as $categoria) {
			if ($ubicacion == $nueva_ubicacion)
				$ubicacion++;
			$categoria->orden = $ubicacion;
			$categoria->save();
			$ubicacion++;
		}

		Response::redirect("backend/categorias/listar");

	}

}
