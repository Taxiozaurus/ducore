<?php
namespace du;

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

	/**
	 * Path traversal in nested arrays (sic!) with dot separated keys
	 *
	 * @param  array $arr
	 * @param  string $path
	 * @param  mixed $default
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public static function path(array $arr, $path = '', $default = NULL) {
		$carry = $arr;
		$keys = explode('.', $path);
		foreach ($keys as $key) {
			if ( ! \array_key_exists($key, $carry))
				return $default;
			$carry = $carry{$key};
		}
		return $carry;
	}
}