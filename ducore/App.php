<?php
namespace du;

/**
 * Main app class
 *
 * @author Taxiozaurus
 */
class App {

	protected $_config;

	/**
	 * Init the app
	 *
	 * @param array $config
	 * @return void
	 * @author Taxiozaurus
	 */
	public function __construct(array $config) {
		$this->_config = $config;
	}

	/**
	 * Find config data
	 *
	 * @param string $field
	 * @param mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public function config(string $field, $default = NULL) {
		return Arr::get($this->_config, $field, $default);
	}

	/**
	 * Start the app
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	public function run() {
		$callable = Route::find(Request::uri());

		$className = '\\' . trim($callable[0], '\\');
		$funcName = trim($callable[1]);

		array_shift($callable);
		array_shift($callable);

		$class = new $className(...$callable);

		$class->before();
		$class->{$funcName}();
		$class->after();
	}
}