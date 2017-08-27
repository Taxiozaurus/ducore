<?php

/**
 * Undocumented class
 *
 * @author Taxiozaurus
 */
class Route {

	/**
	 * Regex escapement string for URIs
	 */
	protected static $_regEscape  = '[.\\+*?[^\\]${}=!|]';
	
	/**
	 * Regex replacement segment
	 */
	protected static $_regSegment = '[^/.,;?\n]++';

	/**
	 * List or registered routes
	 *
	 * @var array
	 */
	protected static $_routes = [];

	/**
	 * Params for current route
	 * 
	 * @var array
	 */
	protected static $_params = [];

	/**
	 * Set/Update a route
	 *
	 * @param string $name    Name for the route, will be set to lowercase
	 * @param string $path    Route URI, can contain keywords wrapped with <>
	 *                        Keywords are matched against the uri and passed to
	 *                        Request util, where they can be accessed
	 *                        via function Route::param(<string> keyword)
	 * @param array  $method  Tuple with [ControllerName, classFunction]
	 *                        Function may not be static and must be public
	 * @return bool  Returns  TRUE if route was set, FALSE otherwise
	 * @author Taxiozaurus
	 */
	public static function set(string $name, string $path, array $method = []) {
		$name = Strings::removeSpaces($name);
		$path = Strings::removeSpaces($path);

		if (strlen($name) AND strlen($path)) {
			$expression = static::regexify($path);

			static::$_routes[strtolower($name)] = ['path' => $path, 'method' => $method, 'pattern' => $expression];
		}
	}

	/**
	 * Create a pattern for matching against the route
	 *
	 * @param  string $path
	 * @return string
	 * @author Taxiozaurus
	 */
	protected static function regexify(string $path): string {
		$expression = preg_replace('#' . static::$_regEscape . '#', '\\\\$0', $path);
		if (strpos($expression, '(') !== FALSE)
		{
			$expression = str_replace(['(', ')'], ['(?:', ')?'], $expression);
		}
		$expression = str_replace(['<', '>'], ['(?P<', '>' . static::$_regSegment . ')'], $expression);
		return '#^' . $expression . '$#uD';	
	}

	/**
	 * Fetches and builds uri from requested route name and keyword params
	 *
	 * @param string $name
	 * @param array $params
	 * @return string
	 * @author Taxiozaurus
	 */
	public static function get(string $name, array $params = []):string {
		$name = Strings::removeSpaces($name);
		$route = Arr::get(static::$_routes, strtolower($name), '');

		$path = $route['path'];

		$list = [];
		$keys = preg_match_all('/<(\w+?)>/', $path, $list);

		foreach ($list as $key) {
			if (strpos($path, "<{$key}>") !== FALSE) {
				$path = str_replace(
					"<{$key}>",
					Arr::get($params, $key, '')
				);
			}
		}

		return preg_replace('/\/+/', '/', $path);
	}

	/**
	 * Find callable from path
	 *
	 * @param string $path
	 * @return string|null
	 * @author Taxiozaurus
	 */
	public static function find(string $path): ?string {
		$row = NULL;
		$path = trim($path, '/');
		foreach (static::$_routes as $route) {
			$pattern = $route['pattern'];
			if (preg_match($pattern, $path, $matches)) {
				$row = $route;
				static::populate_params($matches);
				break;
			}
		}
		if (is_array($row))
			return '\\' . implode('::', $row['method']);
		return NULL;
	}

	/**
	 * Populates $_params array
	 *
	 * @param array $matches
	 * @return void
	 * @author Taxiozaurus
	 */
	protected static function populate_params(array $matches = []) {
		foreach ($matches as $key => $value) {
			if (is_int($key))
				continue;
			static::$_params[$key] = $value;
		}
	}

	/**
	 * Return url params/keys, if key is null, returns all params
	 *
	 * @param string $key
	 * @param mixed  $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function param(string $key = NULL, $default = NULL) {
		if (is_null($key))
			return static::$_params;
		return Arr::get(static::$_params, $key, $default);
	}
}