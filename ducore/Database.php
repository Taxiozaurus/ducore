<?php
namespace du;

use \PDO;

/**
 * Database interaction class
 * 
 * @author Taxiozaurus
 */
class Database {

	/**
	 * PDO database connection
	 *
	 * @var PDO
	 */
	protected static $_pdo;

	/**
	 * List of table metadata already loaded in current process
	 * Stores data retrieved with static::table_meta for reuse
	 *
	 * @var array
	 */
	protected static $_tables = [];

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

	/**
	 * Loads table meta data (short table description)
	 *
	 * @param string $table
	 * @return array|null
	 * @author Taxiozaurus
	 */
	public static function table_meta(string $table): ?array {
		if ( ! array_key_exists($table, static::$_tables)) {
			$q = static::get_pdo()->prepare('DESCRIBE ' . $table);
			$q->execute();
			static::$_tables[$table] = $q->fetchAll(PDO::FETCH_ASSOC);
		}
		return static::$_tables[$table];
	}
}