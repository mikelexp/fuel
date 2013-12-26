<?

namespace Mkcart;

use Fuel\Core\Config;
use Fuel\Core\Session;

class Mkcart {

	private static $session_var;

	private static $_instance = null;

	public static function _init() {

		// config
		Config::load("mkcart", true, true, true);
		static::$session_var = Config::get("mkcart.session_var");

		// instance
		static::$_instance = new Mkcart;

	}

	/**
	 * Devuelve la instancia de Mkcart
	 * @return Mkcart
	 */
	public static function instance() {
		if (static::$_instance === null)
			static::_init();
		return static::$_instance;
	}

	/**
	 * Agrega un nuevo item al carrito
	 * @param Mkcartitem $item Item a agregar
	 * @param bool $force_unique Sumar cantidad y reemplazar por item existente con el mismo ID interno
	 * @return Mkcart
	 */
	public static function add_item(Mkcartitem $item, $force_unique = false) {
		$cart = Mkcart::instance()->cart();
		if ($force_unique && $item->external_id) {
			$new_items = array();
			$match_found = false;
			foreach ($cart['items'] as $i) {
				if ($i->external_id == $item->external_id) {
					$item->quantity += $i->quantity;
					$item->internal_id = ++$cart['last_internal_id'];
					$new_items[] = $item;
					$match_found = true;
				} else {
					$new_items[] = $i;
				}
			}
			if (!$match_found) {
				$item->internal_id = ++$cart['last_internal_id'];
				$new_items[] = $item;
			}
			$cart['items'] = $new_items;
			Session::set(static::$session_var, $cart);
		} else {
			$item->internal_id = ++$cart['last_internal_id'];
			$cart['items'][] = $item;
			Session::set(static::$session_var, $cart);
		}
		static::recalc();
		return static::$_instance;
	}

	/**
	 * Actualizar un item
	 * @param Mkcartitem $item Item a actualizar
	 * @return Mkcart
	 */
	public static function update_item(Mkcartitem $item) {
		$cart = Mkcart::instance()->cart();
		$new_items = array();
		foreach ($cart['items'] as $i) {
			if ($i->internal_id == $item->internal_id) {
				$new_items[] = $item;
			} else {
				$new_items[] = $i;
			}
		}
		$cart['items'] = $new_items;
		Session::set(static::$session_var, $cart);
		static::recalc();
		return static::$_instance;
	}

	/**
	 * Borrar un item
	 * @param Mkcartitem $item Item a borrar
	 * @return Mkcart
	 */
	public static function delete_item(Mkcartitem $item) {
		$cart = Mkcart::instance()->cart();
		$new_items = array();
		foreach ($cart['items'] as $i) {
			if ($i->internal_id != $item->internal_id) {
				$new_items[] = $i;
			}
		}
		$cart['items'] = $new_items;
		Session::set(static::$session_var, $cart);
		static::recalc();
		return static::$_instance;
	}

	/**
	 * Precio total
	 * @return float
	 */
	public static function total() {
		$cart = Mkcart::instance()->cart();
		return $cart['total'];
	}

	/**
	 * Cantidad de items en el carrito
	 * @return int
	 */
	public static function total_items() {
		$cart = Mkcart::instance()->cart();
		return $cart['total_items'];
	}

	/**
	 * Cantidad de items unicos en el carrito
	 * @return int
	 */
	public static function total_items_unique() {
		$cart = Mkcart::instance()->cart();
		return $cart['total_items_unique'];
	}

	/**
	 * Devuelve un item
	 * @param int $internal_id ID interno del item a buscar
	 * @return Mkcartitem
	 * @return null
	 */
	public static function item($internal_id) {
		$cart = Mkcart::instance()->cart();
		foreach ($cart['items'] as $i) {
			if ($i->internal_id == $internal_id) {
				return $i;
			}
		}
		return null;
	}

	/**
	 * Devuelve todos los items del carrito
	 * @return Mkcartitem[]
	 */
	public static function items() {
		$cart = Mkcart::instance()->cart();
		return $cart['items'];
	}

	/**
	 * Devuelve todo el carrito (incluyendo items, totales, etc)
	 * @return array
	 */
	public static function cart() {
		if (static::$_instance === null)
			static::_init();
		$cart = Session::get(static::$session_var);
		if (!$cart) {
			static::clear();
			$cart = Session::get(static::$session_var);
		}
		$items = array();
		foreach ($cart['items'] as $item) {
			$items[] = clone $item;
		}
		$cart['items'] = $items;
		return $cart;
	}

	/**
	 * Agrega un cupon de descuento
	 * @param Mkcartcupon $cupon Cupon a agregar
	 * @return Mkcart
	 */
	public static function add_cupon(Mkcartcupon $cupon) {
		$cart = Mkcart::instance()->cart();
		$cupon->internal_id = ++$cart['cupons_last_internal_id'];
		$cart['cupons'][] = $cupon;
		Session::set(static::$session_var, $cart);
		static::recalc();
		return static::$_instance;
	}

	/**
	 * Actualiza un cupon de descuento
	 * @param Mkcartcupon $cupon Cupon a actualizar
	 * @return Mkcart
	 */
	public static function update_cupon(Mkcartcupon $cupon) {
		$cart = Mkcart::instance()->cart();
		$new_cupons = array();
		foreach ($cart['cupons'] as $c) {
			if ($c->internal_id == $cupon->internal_id) {
				$new_cupons[] = $cupon;
			} else {
				$new_cupons[] = $c;
			}
		}
		$cart['cupons'] = $new_cupons;
		Session::set(static::$session_var, $cart);
		static::recalc();
		return static::$_instance;
	}

	/**
	 * Elimina un cupon de descuento
	 * @param Mkcartcupon $cupon Cupon a eliminar
	 * @return Mkcart
	 */
	public static function delete_cupon(Mkcartcupon $cupon) {
		$cart = Mkcart::instance()->cart();
		$new_cupons = array();
		foreach ($cart['cupons'] as $c) {
			if ($c->internal_id != $cupon->internal_id) {
				$new_cupons[] = $c;
			}
		}
		$cart['cupons'] = $new_cupons;
		Session::set(static::$session_var, $cart);
		static::recalc();
		return static::$_instance;
	}

	/**
	 * Devuelve un cupon
	 * @param int $internal_id ID interno del cupon a buscar
	 * @return Mkcartcupon
	 * @return null
	 */
	public static function cupon($internal_id) {
		$cart = Mkcart::instance()->cart();
		foreach ($cart['cupons'] as $c) {
			if ($c->internal_id == $internal_id) {
				return $c;
			}
		}
		return null;
	}

	/**
	 * Devuelve todos los cupones del carrito
	 * @return Mkcartcupon[]
	 */
	public static function cupons() {
		$cart = Mkcart::instance()->cart();
		return $cart['cupons'];
	}

	/**
	 * Elimina todos los items del carrito
	 */
	public static function clear() {
		if (static::$_instance === null)
			static::_init();
		Session::set(static::$session_var, array(
			"last_internal_id" => 0,
			"items" => array(),
			"total" => 0,
			"total_items" => 0,
			"total_items_unique" => 0,
			"cupons" => array(),
			"cupons_last_internal_id" => 0,
		));
	}

	/**
	 * Recalcula totales del carrito
	 */
	private static function recalc() {
		$cart = Mkcart::instance()->cart();
		// defaults
		$total = 0;
		$total_items = 0;
		$total_items_unique = 0;
		// items
		$new_items = array();
		foreach ($cart['items'] as $item) {
			$subtotal = $item->price * $item->quantity;
			$item->subtotal = $subtotal;
			$new_items[] = $item;
			$total += $subtotal;
			$total_items += $item->quantity;
			$total_items_unique++;
		}
		$cart['items'] = $new_items;
		// cupones
		foreach ($cart['cupons'] as $cupon) {
			if ($cupon->percent) {
				$total = $total - ($total / (100 / ($cupon->percent)));
			} else if ($cupon->price) {
				$total -= $cupon->price;
			}
		}
		// totales
		$cart['total'] = $total;
		$cart['total_items'] = $total_items;
		$cart['total_items_unique'] = $total_items_unique;
		Session::set(static::$session_var, $cart);
	}

}

class Mkcartitem {

	public $internal_id;
	public $external_id;
	public $name;
	public $description;
	public $quantity;
	public $price;
	public $subtotal;
	public $metadata;

	public function __construct($id = null, $name = null, $description = null, $quantity = null, $price = null, $metadata = null) {
		$this->external_id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->quantity = $quantity;
		$this->price = $price;
		$this->metadata = $metadata;
	}

	/**
	 * Crear una nueva instancia de Mkcartitem
	 * @return Mkcartitem
	 */
	public static function forge() {
		return new Mkcartitem;
	}

	/**
	 * Devuelve el item a partir de su ID interno
	 * @param int $internal_id ID interno del item
	 * @return Mkcartitem
	 */
	public static function find($internal_id = null) {
		return Mkcart::instance()->item($internal_id);
	}

	/**
	 * Definir el ID externo del item
	 * @param mixed $valor
	 * @return Mkcartitem
	 */
	public function external_id($valor = null) {
		$this->external_id = $valor;
		return $this;
	}

	/**
	 * Definir el nombre del item
	 * @param string $valor
	 * @return Mkcartitem
	 */
	public function name($valor = null) {
		$this->name = $valor;
		return $this;
	}

	/**
	 * Definir la descripcion del item
	 * @param string $valor
	 * @return Mkcartitem
	 */
	public function description($valor = null) {
		$this->description = $valor;
		return $this;
	}

	/**
	 * Definir la cantidad de items
	 * @param float $valor
	 * @return Mkcartitem
	 */
	public function quantity($valor = null) {
		$this->quantity = $valor;
		return $this;
	}

	/**
	 * Definir el precio del item
	 * @param float $valor
	 * @return Mkcartitem
	 */
	public function price($valor = null) {
		$this->price = $valor;
		return $this;
	}

	/**
	 * Definir la metadata del item
	 * @param mixed $valor
	 * @return Mkcartitem
	 */
	public function metadata($valor = null) {
		$this->metadata = $valor;
		return $this;
	}

	/**
	 * Agrega el item al carrito
	 * @param bool $force_unique
	 * @return Mkcartitem
	 */
	public function add($force_unique = false) {
		Mkcart::instance()->add_item($this, $force_unique);
		return $this;
	}

	/**
	 * Actualiza el item en el carrito
	 * @return Mkcartitem
	 */
	public function update() {
		Mkcart::instance()->update_item($this);
		return $this;
	}

	/**
	 * Elimina el item del carrito
	 * @return Mkcartitem
	 */
	public function delete() {
		Mkcart::instance()->delete_item($this);
		return $this;
	}

}

class Mkcartcupon {

	public $internal_id;
	public $external_id;
	public $name;
	public $description;
	public $percent;
	public $price;

	public function __construct($id = null, $name = null, $description = null, $percent = 0, $price = 0) {
		$this->external_id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->percent = $percent;
		$this->price = $price;
	}

	/**
	 * Devuelve una nueva instancia de Mkcartcupon
	 * @return Mkcartcupon
	 */
	public static function forge() {
		return new Mkcartcupon;
	}

	/**
	 * Devuelve un cupon a partir de su ID interno
	 * @param int $internal_id ID interno del cupon
	 * @return Mkcartcupon
	 */
	public static function find($internal_id = null) {
		return Mkcart::instance()->cupon($internal_id);
	}

	/**
	 * Definir el external ID
	 * @param mixed $valor
	 * @return Mkcartcupon
	 */
	public function external_id($valor = null) {
		$this->external_id = $valor;
		return $this;
	}

	/**
	 * Definir el nombre
	 * @param string $valor
	 * @return Mkcartcupon
	 */
	public function name($valor = null) {
		$this->name = $valor;
		return $this;
	}

	/**
	 * Definir la descripcion
	 * @param string $valor
	 * @return Mkcartcupon
	 */
	public function description($valor = null) {
		$this->description = $valor;
		return $this;
	}

	/**
	 * Definir el porcentaje
	 * @param float $valor
	 * @return Mkcartcupon
	 */
	public function percent($valor = null) {
		$this->percent = $valor;
		return $this;
	}

	/**
	 * Definir el precio
	 * @param float $valor
	 * @return Mkcartcupon
	 */
	public function price($valor = null) {
		$this->price = $valor;
		return $this;
	}

	/**
	 * Agrega el cupon al carrito
	 * @return Mkcartcupon
	 */
	public function add() {
		Mkcart::instance()->add_cupon($this);
		return $this;
	}

	/**
	 * Actualiza el cupon en el carrito
	 * @return Mkcartcupon
	 */
	public function update() {
		Mkcart::instance()->update_cupon($this);
		return $this;
	}

	/**
	 * Elimina el cupon del carrito
	 * @return Mkcartcupon
	 */
	public function delete() {
		Mkcart::instance()->delete_cupon($this);
		return $this;
	}

}
