<?php

/**
 * How to route
 * !! No spaces are allowed !!
 * 
 * For Names
 * Keep it lower case
 * 
 * For URIs
 * Use horn brackets '<>' to specify parameters
 * Any string inside the brackets becomes the param name
 * Wrap optional parts of the url with parentheses '()'
 * 
 * For Callables
 * Must be arrays, with at least 2 keys
 * 0th must be full class name (incl. namespace)
 * 1st must be function name
 * All following keys in the array will be passed to the class constructor
 */
du\Route::set('test-route', 'hello-world(/<id>)', ['Controllers\Home', 'test']);
du\Route::set('db-test', 'user(/<id>)', ['Controllers\Home', 'fetchUser']);

du\Route::set('404', '404', ['Controllers\Home', 'notFound']);

// Default Route
du\Route::set('default', '(<action>(/<id>))', ['Controllers\Home', 'index']);