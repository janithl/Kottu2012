<?php
error_reporting(E_ERROR); 

require('./lib/template.class.php');

/*
	Index.php, where all good things happen :D

	06/05/12	I'm starting this rewrite of Kottu's front-end stuff 
			(for now). Hopefully this time it'll be all MVC and 
			well commented and everything. ;) [janith]

*/

$out = new template();

$out->$item = array('some', 'silly', 'stuff');

$out->render('main.php');

?>
