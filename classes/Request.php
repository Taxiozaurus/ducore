<?php

/**
 * Interface for interacting with the request data
 *
 * @author Taxiozaurus
 */
class Request {

	/**
	 * Init status of the class
	 *
	 * @var bool
	 */
	protected static $_initialized = FALSE;

	/**
	 * Container for _GET
	 *
	 * @var array
	 */
	protected static $_get = [];

	/**
	 * Container for _POST
	 *
	 * @var array
	 */
	protected static $_post = [];

	/**
	 * Container for submitted request JSON body
	 *
	 * @var array
	 */
	protected static $_json = [];

	/**
	 * Contains current uri
	 *
	 * @var string
	 */
	protected static $_uri = '';

	/**
	 * Initialize the class
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	protected static function _init() {
		if (static::$_initialized)
			return;
		static::$_initialized = TRUE;

		static::$_get = static::filter($_GET);
		static::$_post = static::filter($_POST);
		try {
			$body = file_get_contents('php://input');
			static::$_json = (array) JSON::decode($body);
		} catch (Exception $e) {
			unset($e);
		}
	}

	/**
	 * Sanitizer for the data, accepts array of key=>value pairs
	 *
	 * @param  array $data
	 * @return array
	 * @author Taxiozaurus
	 */
	protected static function filter(array $data) {
		return array_map('Strings::sanitize', $data);
	}

	/**
	 * Fetch field from _get if exists, else default,
	 * If $field is NULL, then full _get array is returned
	 *
	 * @param  string|NULL $field
	 * @param  mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function get(string $field = NULL, $default = NULL) {
		static::_init();
		if (is_null($field))
			return static::$_get;
		return Arr::get(static::$_get, $field, $default);
	}

	/**
	 * Fetch field from _post if exists, else default,
	 * If $field is NULL, then full _post array is returned
	 *
	 * @param  string|NULL $field
	 * @param  mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function post(string $field = NULL, $default = NULL) {
		static::_init();
		if (is_null($field)) 
			return static::$_post;
		return Arr::get(static::$_post, $field, $default);
	}

	/**
	 * Fetch field from _body if exists, else default
	 * if $field is null, then full _body array is returned
	 *
	 * @param string $field
	 * @param mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function json(string $field = NULL, $default = NULL) {
		static::_init();
		if (is_null($field))
			return static::$_json;
		return Arr::get(static::$_json, $field, $default);
	}

	/**
	 * Returns current uri
	 *
	 * @return string
	 * @author Taxiozaurus
	 */
	public static function uri():string {
		if ( ! static::$_uri) {
			$uri = $_SERVER['REQUEST_URI'];
			if (strpos($uri, '?') !== FALSE)
				$uri = substr($uri, 0, strpos($uri, '?'));
			static::$_uri = $uri;
		}
		return static::$_uri;
	}
}