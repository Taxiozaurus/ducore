<?php

/**
 * Register autoloader
 *
 * @param string $class
 * @param string $directory
 * @return bool
 * @author Taxiozaurus
 */
spl_autoload_register(function ($class, $directory = '../classes') {
	$class     = ltrim($class, '\\');
	$file = $namespace = '';

	if ($last_namespace_position = strripos($class, '\\'))
	{
		$namespace = substr($class, 0, $last_namespace_position);
		$class     = substr($class, $last_namespace_position + 1);
		$file      = str_replace('\\', '/', $namespace) . '/';
	}

	$file .= str_replace('_', '/', $class);
	$path = $directory . '/' . $file . '.php';
	if (file_exists($path))
	{
		require $path;
		return TRUE;
	}
	return FALSE;
});

/**
 * List of core class names
 */
$classes = scandir('../ducore');

/**
 * Load all the core classes here
 */
foreach ($classes as $class) {
	if (substr($class, -4) === '.php') {
		require "../ducore/{$class}";
	}
}