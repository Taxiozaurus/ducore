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
	 * Get the config
	 */
	$config = require '../config/default.php';
	\du\Conf::init($config);
	unset($config);

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
	$app = new \du\Core;

	$app->run();
} catch (Exception $e) {
	handle_exception($e);
}

/**
 * Exception handler
 */
function handle_exception(Exception $e) {
	$response = new \du\Response;
	$response->json([
		'message' => $e->getMessage(),
		'trace' => $e->getTrace()
	]);

	if ($e->getCode() > 300)
		$response->send($e->getCode());
	$response->send(500);
	exit;
}