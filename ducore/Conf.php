<?php
namespace du;

class Conf {
	protected static $_config = [];

	/**
	 * Initialize the Config class
	 *
	 * @param array $config
	 * @return void
	 * @author Taxiozaurus
	 */
	public static function init(array $config) {
		static::$_config = $config;
	}

	/**
	 * Fetch a config property by name
	 *
	 * @param  string $field
	 * @param  mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function get(string $field, $default = NULL) {
		return Arr::get(static::$_config, $field, $default);
	}

	/**
	 * Fetch config data by key path
	 *
	 * @param  string $path
	 * @param  mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function path(string $path, $default = NULL) {
		return Arr::path(static::$_config, $path, $default);
	}
}