<?php

require('../lib/template.class.php');
require('../lib/dbconn.class.php');
require('../lib/kottu.class.php');

/*
	Index.php, where all good things happen :D

	06/05/12	I'm starting this rewrite of Kottu's front-end stuff 
				(for now). Hopefully this time it'll be all MVC and 
				well commented and everything. ;) [janith]
				
	09/11/12	Doing this mobile jig. Really fun! :D [janith]

*/

$k = new Kottu();
$out = new Template();

if(isset($_GET['search'])) {

	$out->title =  "Search";
	$out->posts = array();
	if(isset($_GET['q']) && strlen($_GET['q']) > 0) {
		$out->posts = $k->search($_GET['q']);
	}
	$out->str = htmlentities(urldecode($_GET['q']));
	
	$out->render('mobile.head.php');
	$out->render('mobile.search.php');
	$out->render('mobile.items.php');
	$out->render('mobile.tail.php');
}
elseif(isset($_GET['post'])) {

	$out->post = $k->fetchpostbyid($_GET['post']);
	$out->title = count($out->post) ? $out->post['title'] : "Post Not Found" ;
	
	$out->render('mobile.head.php');
	$out->render('mobile.post.php');
	$out->render('mobile.tail.php');

}
elseif(isset($_GET['blogroll'])) {

	$out->blogs = $k->fetchallblogs();
	$out->title = "Blogroll";
	
	$out->render('mobile.head.php');
	$out->render('mobile.blogroll.php');
	$out->render('mobile.tail.php');
}
else {

	$lang = isset($_GET['lang']) ? $_GET['lang'] : 'all';
	$time = isset($_GET['hot']) ? $_GET['hot'] : 'off';

	$out->title =  titlemaker($lang, $time);
	$out->posts = $k->fetchallposts($lang, $time);
	
	$out->render('mobile.head.php');
	$out->render('mobile.items.php');
	$out->render('mobile.tail.php');
}

function titlemaker($lang, $time) {

	$l = '';
	$t = '';
	$title = '';
	
	if($lang == 'en') {	
		$l = " English";
	}
	elseif($lang == 'si') {
		$l = " Sinhala";
	}
	elseif($lang == 'ta') {
		$l = " Tamil";
	}
	
	if($time == 'today') {	
		$t = " today";
	}
	elseif($time == 'week' || $time == 'month') {
		$t = " this ".$time;
	}
	
	if($t == '') {
		$title = "Latest ".$l."posts";
	}
	else {
		$title = "Hot$l posts$t";
	}
	
	return $title;
}

?>
