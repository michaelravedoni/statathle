<?php  

return array(
    'development' => array(
        'driver' => 'mysql',
		'host' => 'localhost',
		'port' => '8889',
		'database' => 'stats',
		'username' => 'root',
		'password' => 'root',
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci'
    ),
    'production' => array(
		'driver' => 'mysql',
		'host' => '',
		'port' => '',
		'database' => '',
		'username' => '',
		'password' => '',
		'charset' => '',
		'collation' => ''
    ),
);