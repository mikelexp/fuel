<?

namespace Orm;

class Observer_Prepurl extends Observer {

	public static $fields;
	protected $_fields;

	public function __construct($class) {
		$props = $class::observers(get_class($this));
		$this->_fields = isset($props['fields']) ? $props['fields'] : static::$fields;
	}

	public function before_insert(Model $model) {
		$fields = $this->_fields;
		foreach ($fields as $field) {
			$model->$field = \Uri::prep_url($model->$field);
		}
	}

	public function before_update(Model $model) {
		$this->before_insert($model);
	}

}
