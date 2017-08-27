<?php

/**
 * Array utility class
 *
 * @author Taxiozaurus
 */
class Arr {

	/**
	 * Return value from array if key exists, else return default
	 *
	 * @param  array $arr
	 * @param  string|int $key
	 * @param  mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function get(array $arr, $key = NULL, $default = NULL) {
		return array_key_exists($key, $arr) ? $arr[$key] : $default;
	}
}