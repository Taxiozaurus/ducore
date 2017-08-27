<?php

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

		if ($callable)
			return call_user_func($callable);
		throw new Exception('404 Not found');
	}
}