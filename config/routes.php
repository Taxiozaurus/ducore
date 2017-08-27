<?php

Route::set('test-route', 'hello-world(/<id>)', ['Controllers\BaseController', 'test']);
Route::set('db-test', 'user(/<id>)', ['Controllers\BaseController', 'fetch_user']);

// Default Route
Route::set('default', '(<action>(/<id>))', ['Controllers\BaseController', 'index']);