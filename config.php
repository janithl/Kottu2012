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
$config['argstart']	= 1;

/* base paths and stuff */
$config['basepath'] = 'http://localhost:8000';

/* cache times, 30 minutes for static pages, 3 minutes for dynamic ones */
$config['stacache'] = 1800;
$config['dyncache'] = 180;

/* back-end secret key */
$config['besecret'] = sha1('backendsecretkeywithunicorns');

/* facebook graph api token */
$config['fbtoken'] 	= '';

/* facebook app id and secret key */
$config['fbappid']	= 'id';
$config['fbappkey']	= 'key';

/* Weight given to various factors when calculating spice (adds up to 1) */
$config['twweight']	= 0;
$config['fbweight'] = 0.3;
$config['clweight'] = 0.7;

/** gravity for trend */
$config['gravity']  = 1.6;
	
function config($key) {
	global $config;
	return $config[$key];
}

?>
