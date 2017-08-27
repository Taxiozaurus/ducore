<?php

/**
 * Base controller class
 *
 * @author Taxiozaurus
 */
class BaseController {

	/**
	 * View class container
	 *
	 * @var BaseView
	 */
	protected $view;

	/**
	 * Response class container
	 * 
	 * @var Response
	 */
	protected $response;

	/**
	 * Construct a new controller
	 *
	 * @param array $args
	 * @author Taxiozaurus
	 */
	public function __construct(...$args) {
		$this->response = new Response;
		$this->view = new BaseView;
	}

	/**
	 * All code in the before function, will run before running the callable
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	public function before() {
	}

	/**
	 * All code in the after function will run after the callable
	 *
	 * @return void
	 * @author Taxiozaurus
	 */
	public function after() {
		$this->response->setBody(
			$this->view->render('home')
		)->send();
	}
}