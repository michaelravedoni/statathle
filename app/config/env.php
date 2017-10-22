<?php  

return array(
	
	// Set the ENVIRONMENT mode
	// Choose between 'development' and 'production'
	
	'mode' => 'development',
	
    'development' => array(
        'driver' => 'mysql',
		'siteUrl' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/statathle/',
    ),
    'production' => array(
		'driver' => 'mysql',
		'siteUrl' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '',
    ),
);