<?php
namespace Controllers;

use \Response;
use \Request;
use \Route;

class BaseController {

	public function test() {
		$response = new Response;
		$response->json([
			'get' => Request::get(),
			'post' => Request::post(),
			'uri' => Request::uri(),
			'params' => Route::param()
		])->send();
	}
}