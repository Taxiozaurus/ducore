<?php
namespace du;

/**
 * Core application class
 *
 * @author Taxiozaurus
 */
class Core {

	/**
	 * Init the app
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	public function __construct() {
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