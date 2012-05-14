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

if($path[$i] == 'register') {

	echo '<a href="' . $_POST['redir'] . '">back</a>';
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
