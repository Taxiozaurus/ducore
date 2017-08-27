<?php

/**
 * Build a response and send it
 *
 * @author Taxiozaurus
 */
class Response {

	/**
	 * Response body container
	 *
	 * @var string
	 */
	protected $_body = '';

	/**
	 * Response headers container
	 *
	 * @var array
	 */
	protected $_head = [];

	/**
	 * Response type container
	 * Default: HTML text
	 * 
	 * @var string
	 */
	protected $_type = 'text/html';

	/**
	 * Construct the response
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	public function __constructor() {
	}

	/**
	 * Set json body return
	 *
	 * @param [type] $data
	 * @return self
	 * @author Taxiozaurus
	 */
	public function json($data) {
		$this->_body = JSON::encode($data);
		$this->setType('application/json');

		return $this;
	}

	/**
	 * Set response mime type
	 *
	 * @param string $type
	 * @return self
	 * @throws Exception
	 * @author Taxiozaurus
	 */
	public function setType(string $type) {
		if (Strings::checkMime($type)) {
			$this->_type = $type;
		} else {
			throw new Exception('Unknown MIME type: ' . $type);
		}
		return $this;
	}

	/**
	 * Set response body
	 *
	 * @param string $body
	 * @return self
	 * @author Taxiozaurus
	 */
	public function setBody(string $body) {
		$this->_body = $body;
		return $this;
	}

	/**
	 * Sends the response to the client and closes the connection
	 * @note that code will still continue to run 
	 *       so you can do some postprocessing after sending a response
	 *
	 * @param int $code Default 200, response status code
	 * @return void
	 * @author Taxiozaurus
	 */
	public function send(int $code = 200) {
		
		// Set response code
		http_response_code($code);

		if ($this->_body)
			echo $this->_body;
		
		$size = ob_get_length();
		header('Connection: close');
		header('Content-Length:' . $size);
		
		// Set body type
		header('Content-Type: ' . $this->_type);
		
		// Begin by settin headers
		foreach ($this->_head as $row) {
			header($row);
		}

		ob_end_flush();
		flush();
	}
}