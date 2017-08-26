<?php

Route::set('test-route', 'hello-world(/<id>)', ['Controllers\BaseController', 'test']);