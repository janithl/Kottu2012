<?php
error_reporting(E_ERROR | E_WARNING);

require('./config.php');
require('./lib/template.class.php');
require('./lib/dbconn.class.php');
require('./lib/kottu.class.php');

/*
	Index.php, where all good things happen :D

	06/05/12	I'm starting this rewrite of Kottu's front-end stuff 
				(for now). Hopefully this time it'll be all MVC and 
				well commented and everything. ;) [janith]
				
	09/11/12	Doing this mobile jig. Really fun! :D [janith]

*/

$k		= new Kottu();
$out	= new Template();

$path	= explode('/', $_SERVER['REQUEST_URI']);
$i		= config('argstart');

if($path[$i] == 'go') {

	/* The artist formerly known as go.php */

	if(isset($_GET['url'])) {
	
		$k->insertclick($_SERVER['REMOTE_ADDR'], $_GET['id']);
		header("location: " . $_GET['url']);
	}
	else {
		
		header("location: " . config('basepath'));
	}
}
elseif($path[$i] == 'blogroll') {

	/* Blogroll */
	
	$out->title		= 'Kottu: Blogroll';
	$out->blogs 	= $k->fetchallblogs();
	$out->popblogs	= $k->fetchpopblogs();
	$out->numblogs	= $k->fetchnumblogs();
	
	/* To make sure links all work */
	
	$out->lang = 'all';
	$out->time = 'off';
	$out->page = 0;

	$out->render('web/head.php');
	$out->render('web/blogroll.php');
	$out->render('web/tail.php');
}
elseif($path[$i] == 'about') {
	
	$out->title		= 'Kottu: About Us';
	$out->numblogs	= $k->fetchnumblogs();
	
	$out->lang = 'all';
	$out->time = 'off';
	$out->page = 0;

	$out->render('web/head.php');
	$out->render('web/about.php');
	$out->render('web/tail.php');
}
elseif($path[$i] == 'feed') {
	
	/* RSS feeds */
	
	$lang	= isset($path[$i + 1]) && strlen($path[$i + 1]) ? $path[$i + 1] : 'all';
	$time	= isset($path[$i + 2]) && strlen($path[$i + 2]) ? $path[$i + 2] : 'off';

	$out->title =  "Kottu: " . titlemaker($lang, $time);
	$out->posts = $k->fetchallposts($lang, $time);
	$out->date	= date('D, d M Y H:i:s O', time());
	$out->lang	= $lang;

	$out->render('rss.php');
}
elseif($path[$i] == 'm') {
	
	/* Mobile site */
	
	if($path[$i + 1] == 'search') {

		$out->title =  "Search";
		$out->posts = array();
		$out->str	= '';
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		$out->next	= "./?q={$_GET['q']}&page=" . ((int)$page + 1);
	
		if(isset($_GET['q']) && strlen($_GET['q']) > 0) {
			$out->posts = $k->search($_GET['q'], $page);
			$out->str	= htmlentities(urldecode($_GET['q']));
		}
	
		$out->render('mobile/head.php');
		$out->render('mobile/search.php');
		$out->render('mobile/items.php');
		$out->render('mobile/tail.php');
	}
	elseif($path[$i + 1] == 'post') {

		$out->post	= $k->fetchpostbyid($path[$i + 2]);
		$out->title = count($out->post) ? $out->post['title'] : "Post Not Found";
	
		$out->render('mobile/head.php');
		$out->render('mobile/post.php');
		$out->render('mobile/tail.php');

	}
	elseif($path[$i + 1] == 'blogroll') {

		$out->blogs = $k->fetchallblogs();
		$out->title = "Blogroll";
	
		$out->render('mobile/head.php');
		$out->render('mobile/blogroll.php');
		$out->render('mobile/tail.php');
	}
	else {

		$lang = isset($_GET['lang']) ? $_GET['lang'] : 'all';
		$time = isset($_GET['hot']) ? $_GET['hot'] : 'off';
		$page = isset($_GET['page']) ? $_GET['page'] : 0;

		$out->next	= "./?lang=$lang&hot=$time&page=" . ((int)$page + 1);
		$out->title =  titlemaker($lang, $time, $page + 1);
		$out->posts = $k->fetchallposts($lang, $time, $page);
	
		$out->render('mobile/head.php');
		$out->render('mobile/items.php');
		$out->render('mobile/tail.php');
	}
}
elseif($path[$i] == 'search') {

	/* Web Search */
	
	$out->title =  "Kottu: Search";
	$out->posts = array();
	$out->str	= '';
	
	if(isset($_GET['q']) && strlen($_GET['q']) > 0) {
		$out->posts = $k->search($_GET['q'], $out->page);
		$out->str	= urldecode($_GET['q']);
	}
	
	/* To make sure links all work */
	
	$out->lang	= 'all';
	$out->time	= 'off';
	$out->page	= isset($_GET['page']) ? $_GET['page'] : 0;

	$out->render('web/head.php');
	$out->render('web/items.php');
	$out->render('web/tail.php');
}
elseif($path[$i] == 'blog') {
	
	/* Display posts from one blog */
	
	$out->bid	= isset($path[$i + 1]) && strlen($path[$i + 1]) ? $path[$i + 1] : 0;
	$out->blog	= $k->blogdetails($out->bid);
	$out->lang	= 'all';
	$out->time	= 'off';
	$out->page	= isset($path[$i + 2]) && strlen($path[$i + 2]) ? $path[$i + 2] : 0;
	
	$out->title = "Kottu: Posts from " . $out->blog['name'];
	$out->posts = $k->fetchblogposts($path[$i + 1], $out->page);
	
	$out->numblogs	= $k->fetchnumblogs();
	$out->hotposts	= array_slice($k->fetchallposts('all', 'today'), 0, 5);
	$out->evillage	= $k->sidescroller();

	$out->render('web/head.php');
	$out->render('web/items.php');
	$out->render('web/sidebar.php');
	$out->render('web/tail.php');
}
elseif($path[$i] == '' || preg_match('/^(all|en|si|ta)$/', $path[$i]) && 
	(!isset($path[$i+1]) || $path[$i+1] == '' || 
	preg_match('/^(off|today|week|month|all)$/', $path[$i+1]))) {

	/* Normal Kottu website */

	$out->lang = isset($path[$i]) && strlen($path[$i]) ? $path[$i] : 'all';
	$out->time = isset($path[$i + 1]) && strlen($path[$i + 1]) ? $path[$i + 1] : 'off';
	$out->page = isset($path[$i + 2]) && strlen($path[$i + 2]) ? $path[$i + 2] : 0;

	$out->title =  'Kottu: ' . titlemaker($out->lang, $out->time, $out->page + 1);
	$out->numblogs	= $k->fetchnumblogs();
	$out->posts		= $k->fetchallposts($out->lang, $out->time, $out->page);
	$out->hotposts	= array_slice($k->fetchallposts('all', 'today'), 0, 5);
	$out->evillage	= $k->sidescroller();

	$out->render('web/head.php');
	$out->render('web/items.php');
	$out->render('web/sidebar.php');
	$out->render('web/tail.php');
}

function titlemaker($lang='all', $time='off', $page=1) {

	$l = array(	'all'	=> '',
				'en'	=> ' English',
				'si'	=> ' Sinhala',
				'ta'	=> ' Tamil');

	$t = array(	'off'	=> '',
				'today'	=> ' Today',
				'week'	=> ' This Week',
				'month'	=> ' This Month');

	$title = ($time == 'off') ? "Latest" : "Hot";
	$title .= "{$l[$lang]} Posts{$t[$time]}";
	$title .= ($page > 1) ? " (page $page)" : '';
	
	return $title;
}

?>
