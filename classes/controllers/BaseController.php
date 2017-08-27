<?php
namespace Controllers;

use \Response;
use \Request;
use \Route;
use \Models\User;

class BaseController {

	public function index() {
		$response = new Response;
		$response->setBody('Hello world!');
		$response->send();
	}

	public function test() {
		$response = new Response;
		$response->json([
			'get' => Request::get(),
			'post' => Request::post(),
			'uri' => Request::uri(),
			'params' => Route::param()
		])->send();
	}

	public function fetch_user() {
		$model = new User(Route::param('id'));

		$response = new Response;
		$response->json([
			'data' => $model->as_array(),
			'loaded' => $model->loaded()
		])->send();
	}
}