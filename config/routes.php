<?php

Route::set('test-route', 'hello-world(/<id>)', ['Controllers\BaseController', 'test']);
Route::set('db-test', 'user(/<id>)', ['Controllers\BaseController', 'fetch_user']);