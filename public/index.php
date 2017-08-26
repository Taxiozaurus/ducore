<?php
session_start();

/**
 * Exception handler
 */
function handle_exception(Exception $e) {
	echo json_encode([
		'message' => $e->getMessage(),
		'trace' => $e->getTrace()
	]);
}

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