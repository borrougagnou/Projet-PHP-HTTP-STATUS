<?php
	$routes = array(
		'Ping' => [
			'home' => '/',
			'addhtml' => '/add',
			'statushtml' => '/status/{uid}',
			'historyhtml' => '/history/{uid}',
			'api' => '/api/',
			'myadd' => '/api/add',
			'liste' => '/api/list',
			'mydelete' => '/api/delete/{uid}',
			'mystatus' => '/api/status/{uid}',
			'myhistory' => '/api/history/{uid}',
		]
	);

	define('ROUTES', $routes);
