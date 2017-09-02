<?php
namespace du;

/**
 * Base View
 * This is an inbuilt basic template managing class
 * It stores variables for use in templates
 * And renders html for output
 *
 * @author Taxiozaurus
 */
class BaseView {

	/**
	 * Template variable store
	 *
	 * @var array
	 */
	protected $_vars = [];

	/**
	 * Set a var for use in template
	 * Accepts assoc. arrays for bulk set
	 *
	 * @param array|string $key
	 * @param mixed $value
	 * @return bool
	 * @author Taxiozaurus
	 */
	public function set($key = NULL, $value = NULL): bool {
		if (is_string($key)) {
			$this->_vars = $value;
			return TRUE;
		} elseif (is_array($key)) {
			$this->_vars = array_merge(
				$this->_vars,
				$key
			);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Render a template
	 *
	 * @param string $template
	 * @return string
	 * @author Taxiozaurus
	 */
	public function render(string $template = NULL): string {
		if ($template) {
			ob_start();
			$du = (object) $this->_vars;
			$conf = new Conf;
			include '../templates/index.php';
			$rendered = ob_get_contents();
			ob_end_clean();
			return $rendered;
		}
		return '';
	}

	/**
	 * Echo out a string
	 *
	 * @param string $str
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function e(string $str) {
		echo $str;
	}

	/**
	 * Print_r given data
	 *
	 * @param mixed $data
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function p($data) {
		print_r($data);
	}

	/**
	 * Json encode and echo given data
	 *
	 * @param mixed $data
	 * @return void
	 * @author Taxiozaurus
	 */
	protected function j($data) {
		echo JSON::encode($data);
	}
}