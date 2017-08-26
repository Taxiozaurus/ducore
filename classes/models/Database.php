<?php
namespace Models;

use \PDO;

class Database {

	/**
	 * PDO database connection
	 *
	 * @var PDO
	 */
	protected static $_pdo;

	/**
	 * Get database connection PDO object
	 *
	 * @return PDO
	 * @author Taxiozaurus
	 */
	public static function get_pdo():PDO {
		if ( ! static::$_pdo) {
			static::$_pdo = new PDO(
				'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, 
				DB_USER,
				DB_PASS
			);
		}
		return static::$_pdo;
	}
}