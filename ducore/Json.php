<?php

/**
 * JSON abstraction class
 *
 * @author Taxiozaurus
 */
class JSON {

	protected static $_errors = [
		JSON_ERROR_NONE                  => 'JSON_ERROR_NONE',
		JSON_ERROR_DEPTH                 => 'JSON_ERROR_DEPTH',
		JSON_ERROR_STATE_MISMATCH        => 'JSON_ERROR_STATE_MISMATCH',
		JSON_ERROR_CTRL_CHAR             => 'JSON_ERROR_CTRL_CHAR',
		JSON_ERROR_SYNTAX                => 'JSON_ERROR_SYNTAX',
		JSON_ERROR_UTF8                  => 'JSON_ERROR_UTF8',
		JSON_ERROR_RECURSION             => 'JSON_ERROR_RECURSION',
		JSON_ERROR_INF_OR_NAN            => 'JSON_ERROR_INF_OR_NAN',
		JSON_ERROR_UNSUPPORTED_TYPE      => 'JSON_ERROR_UNSUPPORTED_TYPE',
		JSON_ERROR_INVALID_PROPERTY_NAME => 'JSON_ERROR_INVALID_PROPERTY_NAME',
		JSON_ERROR_UTF16                 => 'JSON_ERROR_UTF16'
	];

	/**
	 * Encode data to a JSON string
	 *
	 * @param mixed $data
	 * @return string|null
	 * @throws Exception
	 * @author Taxiozaurus
	 */
	public static function encode($data): ?string {
		$encoded = json_encode($data);
		$last_error = json_last_error();
		if ($last_error !== JSON_ERROR_NONE)
			throw new Exception('Could not encode to JSON, error: ' . static::$_errors[$last_error]);
		return $encoded;
	}

	/**
	 * Decode a json string
	 *
	 * @param string $data
	 * @param bool $assoc
	 * @return mixed
	 * @throws Exception
	 * @author Taxiozaurus
	 */
	public static function decode(string $data, bool $assoc = FALSE) {
		$decoded = json_decode($data, $assoc);
		$last_error = json_last_error();
		if ($last_error !== JSON_ERROR_NONE)
			throw new Exception('Could not decode from JSON, error: ' . static::$_errors[$last_error]);
		return $decoded;
	}
}