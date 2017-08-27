<?php
session_start();

/**
 * Run the app
 */
try {

	/**
	 * Run the boostrap
	 */
	require '../bootstrap.php';

	/**
	 * Define constants
	 */
	$config = require '../config/default.php';

	/**
	 * Set DB config
	 */
	require '../config/database.php';

	/**
	 * Load the routes
	 */
	require '../config/routes.php';

	/**
	 * Init the app
	 */
	$app = new App($config);

	$app->run();
} catch (Exception $e) {
	handle_exception($e);
}

/**
 * Exception handler
 */
function handle_exception(Exception $e) {
	$response = new Response;
	$response->json([
		'message' => $e->getMessage(),
		'trace' => $e->getTrace()
	]);

	if ($e->getCode() > 300)
		$response->send($e->getCode());
	$response->send(500);
	exit;
}