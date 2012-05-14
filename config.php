<?php

/*
	config.php, for configuration info
	
	12/05/12	Created this, based on Jerry's file for twt. [janith]
*/

global $config;

/* DB settings */

$config['dbhost']	= 'localhost';
$config['dbname']	= 'kottu';
$config['dbuser']	= 'root';
$config['dbpwd']	= '';

/* Index of first argument */

$config['argstart']	= 2;

/* base paths and stuff */

$config['basepath'] = 'http://localhost/k2012';
	
function config($key) {
	global $config;
	return $config[$key];
}

?>
