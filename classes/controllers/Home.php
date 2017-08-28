<?php
namespace Controllers;

use \du\Response;
use \du\Request;
use \du\Route;
use \Models\User;

class Home extends \du\BaseController {

	public function index() {
		/*
		$response = new Response;
		$response->setBody('Hello world!');
		$response->send();
		*/
	}

	public function test() {
		$this->response->json([
			'get' => Request::get(),
			'post' => Request::post(),
			'uri' => Request::uri(),
			'params' => Route::param()
		])->send();
	}

	public function fetchUser() {
		$model = new User(Route::param('id'));

		$this->response->json([
			'data' => $model->as_array(),
			'loaded' => $model->loaded()
		])->send();
	}

	public function notFound() {
		throw new \Exception('404', 404);
	}
}