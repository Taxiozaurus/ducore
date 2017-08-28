<?php
namespace du;

use \PDO;
use \Exception;

/**
 * Base model for interaction with DB at object level
 *
 * Extend from this class when creating new model classes.
 * 
 * @author Taxiozaurus
 */
class BaseModel extends \stdClass {

	/**
	 * Table name
	 *
	 * @var string
	 */
	protected $_table = '';

	/**
	 * Available columns for the model
	 *
	 * @var array
	 */
	protected $_columns = [];

	/**
	 * Primary key of the table
	 *
	 * @var string
	 */
	protected $_pk = '';

	/**
	 * Primary key value
	 *
	 * @var string
	 */
	protected $_pkv = '';

	/**
	 * Row data
	 *
	 * @var array
	 */
	protected $_data = [];

	/**
	 * Load status of the model
	 *
	 * @var bool
	 */
	protected $_loaded = false;

	/**
	 * Construct the model
	 *
	 * @param string|int $id
	 * @author Taxiozaurus
	 */
	public function __construct($id = NULL) {

		if (empty($this->_table))
			throw new Exception('Table name in class ' . get_class($this) . ' is not defined');

		$this->_prepare();

		if ( ! empty($id))
			$this->_load_data($id);	
	}

	/**
	 * Fetch data form the object
	 *
	 * @param  string $key
	 * @return mixed
	 * @throws Exception
	 * @author Taxiozaurus
	 */
	public function __get(string $key) {
		if (array_key_exists($key, $this->_data)) {
			return $this->_data[$key];
		}
		throw new Exception('Property "' . $key . '" does not exist in class ' . get_class($this));
	}

	/**
	 * Set object data
	 *
	 * @param string $key
	 * @param mixed $val
	 * @return void
	 * @throws Exception
	 * @author Taxiozaurus
	 */
	public function __set(string $key, $val) {
		if ($key and in_array($key, $this->_columns)) {
			$this->_data[$key] = $val;
		} else {
			throw new Exception('Cannot set property "' . $key . '", it is either empty or does not exist in class ' . get_class($this));
		}
	}

	/**
	 * Is a key set
	 *
	 * @param string $key
	 * @return bool
	 * @author Taxiozaurus
	 */
	public function __isset(string $key): bool {
		return array_key_exists($key, $this->_data);
	}

	/**
	 * Stringify this class
	 *
	 * @return string
	 * @author Taxiozaurus
	 */
	public function __toString(): string {
		return (string) $this->_pkv;
	}

	/**
	 * Prepare model for usage
	 * Function sets up available columns and primary key 
	 * to allow usage of save/update functionality
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function _prepare() {
		$table_data = Database::table_meta($this->_table);

		foreach ($table_data as $row) {
			$field = $row['Field'];
			$this->_columns[] = $field;
			$this->_data[$field] = NULL;

			if ($row['Key'] === 'PRI') {
				$this->_pk = $field;
			}
		}
	}

	/**
	 * Loads row data into the model
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function _load_data($id) {
		$q = Database::get_pdo()->prepare("SELECT * FROM {$this->_table} WHERE {$this->_pk} = :id LIMIT 0,1");
		$q->execute([':id' => $id]);
		$row = $q->fetchAll(PDO::FETCH_ASSOC);

		$tmp = [];
		$data = (array) current($row);
		foreach ($this->_columns as $column) {
			$tmp[$column] = Arr::get($data, $column);
		}

		$this->_data = $tmp;
		$this->_pkv = Arr::get($tmp, $this->_pk, '');
		$this->_loaded = ( ! empty(array_filter($this->_data)));
	}

	/**
	 * Return current row data as array
	 *
	 * @return array
	 * @author Taxiozaurus
	 */
	public function as_array(): array {
		return $this->_data;
	}

	/**
	 * Is model loaded
	 *
	 * @return bool
	 * @author Taxiozaurus
	 */
	public function loaded(): bool {
		return $this->_loaded;
	}

	/**
	 * Save the model
	 *
	 * @return mixed
	 * @author Taxiozaurus
	 */
	public function save() {
		if ($this->loaded()) {
			return $this->_update();
		} else {
			return $this->_create();
		}
	}

	/**
	 * Update a row in db for a loaded model
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function _update() {
		if ( ! $this->loaded() OR ! $this->_pkv)
			throw new Exception('Can\'t update non-loaded models');
		
		$filtered = array_filter($this->_data);
		if ( ! count($filtered))
			throw new Exception('Nothing to save');
		
		$values = [];
		$query = "UPDATE {$this->_table} SET ";
		foreach ($filtered as $column => $value) {
			$query .= "{$column} = :{$column},";
			$values[":{$column}"] = $value;
		}
		$query = rtrim($query, ',');
		$query .= " WHERE {$this->_pk} = :_pkv";

		$q = Database::get_pdo()->prepare($query);
		$q->execute(array_merge(
			$values, [':_pkv' => $this->_pkv]
		));

		return TRUE;
	}

	/**
	 * Create new row in the db for the submitted data
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function _create() {
		if ($this->loaded() OR $this->_pkv)
			throw new Exception('Can\'t recreate existing row');
		
		$filtered = array_filter($this->_data);
		if ( ! count($filtered))
			throw new Exception('Nothing to insert');
		
		$valuePrep = array_map(function($item) {
			return '?';
		}, $filtered);

		$query = str_replace(
			[':columns', ':values'],
			[implode(', ', array_keys($filtered)), implode(', ', $valuePrep)],
			"INSERT INTO {$this->_table} (:columns) VALUES (:values)"
		);

		$q = Database::get_pdo()->prepare($query);
		$q->execute(array_values($filtered));
		$id = Database::get_pdo()->lastInsertId();

		// To insure data integrity, load the model anew
		$this->_load_data($id);

		return TRUE;
	}

	/**
	 * Reload the model data
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	public function reload() {
		if ( ! $this->loaded() OR ! $this->_pkv)
			throw new Exception('Can only reload loaded models');
		$this->_load_data($this->_pkv);
	}
}