<?php

require('./config.php');

/*
	Index.php, where all good things happen :D

	06/05/12	I'm starting this rewrite of Kottu's front-end stuff (for now).
				Hopefully this time it'll be all MVC and well commented and 
				everything. ;) [janith]
				
	09/05/12	Doing this mobile jig. Really fun! :D [janith]
	
	17/05/12	Cleaned stuff up because stuff that worked on localhost stopped
				working on the server. Ugly URLs galore. :( [janith]
				
	04/06/12	Fixing up a web cache [janith]
	
	08/06/12	Administration options / backend finally added :P [janith]
	
	09/06/12	Added tags, cleaned up navigation code etc. [janith]
	
	21/08/12	Adding admin backend [janith]
*/

$path		= explode('/', $_SERVER['REQUEST_URI']);
$i			= config('argstart');
$cachetime	= ($path[$i] == 'about' || $path[$i] == 'blogroll') ?
				config('stacache') : config('dyncache');
$cachefile	= "./webcache/" . implode('_', $path) . ".html";

/* serve from the cache if it is younger than $cachetime */
if(file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {

	readfile($cachefile);
	echo "<!-- Served with love from the Kottu cache. Page generated " ,
	(time() - filemtime($cachefile)) , " seconds ago. -->\n";
}
else {

	require('./lib/template.class.php');
	require('./lib/dbconn.class.php');
	require('./lib/db.class.php');
	require('./lib/kottu.class.php');

	$k		= new Kottu();
	$out	= new Template();
	$out->toplink		= 'off';
	$out->currentpage	= 'all/off/';
	
	$janithstart = microtime(true);

	if($path[$i] == 'go') {

		/* The artist formerly known as go.php */

		if(isset($_GET['url'])) {

			$k->insertclick($_SERVER['REMOTE_ADDR'], $_GET['id']);
			header("location: " . $_GET['url']);
		}
		else {

			header('location: ' . config('basepath'));
		}
	}
	elseif($path[$i] == 'admin') {
		
		if(($path[$i + 1] == 'cacheclear' || $path[$i + 1] == 'feedget' ||
			$path[$i + 1] == 'calculatespice') && sha1($path[$i + 2]) === 
			config('besecret')) {
			
			require('./lib/kottubackend.class.php');
			$kbe = new KottuBackend();
			
			/* callback */
			call_user_func(array($kbe, $path[$i + 1]));
		}
		else {
		
			unset($k);
		
			require('./lib/kottuadmin.class.php');
			$ka = new KottuAdmin();
			
			$ka->route($path[$i + 1], $out);
		}
	}
	elseif($path[$i] == 'blogroll') {
	
		/* start output buffer */
		ob_start();

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
		
		/* save contents of buffer into cache file */
		$fp = fopen($cachefile, 'w'); 
		fwrite($fp, ob_get_contents());
		fclose($fp); 

		/* send buffer contents to browser */
		ob_end_flush();
	}
	elseif($path[$i] == 'about') {
	
		/* start output buffer */
		ob_start();
	
		$out->title		= 'Kottu: About Us';
		$out->numblogs	= $k->fetchnumblogs();
	
		$out->lang = 'all';
		$out->time = 'off';
		$out->page = 0;

		$out->render('web/head.php');
		$out->render('web/about.php');
		$out->render('web/tail.php');
		
		/* save contents of buffer into cache file */
		$fp = fopen($cachefile, 'w'); 
		fwrite($fp, ob_get_contents());
		fclose($fp); 

		/* send buffer contents to browser */
		ob_end_flush();
	}
	elseif($path[$i] == 'feed') {
	
		/* RSS feeds - no buffering */

		$lang	= isset($path[$i + 1]) && strlen($path[$i + 1]) ? $path[$i + 1] : 'all';
		$time	= isset($path[$i + 2]) && strlen($path[$i + 2]) ? $path[$i + 2] : 'off';

		$out->title =  "Kottu: " . titlemaker($lang, $time);
		$out->posts = $k->fetchallposts($lang, $time);
		$out->date	= date('D, d M Y H:i:s O', time());
		$out->lang	= $lang;

		$out->render('rss.php');
		
	}
	elseif($path[$i] == 'm') {
	
		/* start output buffer */
		ob_start();

		/* Mobile site */

		if(isset($_GET['search'])) {

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
		elseif(isset($_GET['post'])) {

			$out->post = $k->fetchpostbyid($_GET['post']);
			$out->title = count($out->post) ? $out->post['title'] : "Post Not Found" ;
	
			$out->render('mobile/head.php');
			$out->render('mobile/post.php');
			$out->render('mobile/tail.php');

		}
		elseif(isset($_GET['blogroll'])) {

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
			$out->title =  titlemaker($lang, $time, $page);
			$out->posts = $k->fetchallposts($lang, $time, $page);
	
			$out->render('mobile/head.php');
			$out->render('mobile/items.php');
			$out->render('mobile/tail.php');
		}
		
		/* save contents of buffer into cache file */
		$fp = fopen($cachefile, 'w'); 
		fwrite($fp, ob_get_contents());
		fclose($fp); 

		/* send buffer contents to browser */
		ob_end_flush();
		
	}
	elseif($path[$i + 1] == 'tags' && strlen($path[$i + 2]) > 0) {
	
		/* Tags */
		
		$out->title = "Kottu: Posts Tagged Under " . htmlentities($path[$i + 2]);
		$out->posts = array();
		$out->numblogs	= $k->fetchnumblogs();
		
		$out->page	= isset($path[$i + 3]) && strlen($path[$i + 3]) ? 
								$path[$i + 3] : 0;
		$out->lang	= $path[$i];
		$out->posts = $k->search('', $out->page, $path[$i], $path[$i + 2]);
		$out->hotposts	= array_slice($k->fetchallposts('all', 'today'), 0, 5);
		$out->trending	= $k->trendingtopics();
		$out->toplink	= "tags/{$path[$i + 2]}/";
		$out->currentpage	= $out->lang . '/' . $out->toplink;
		
		$out->render('web/head.php');
		$out->render('web/items.php');
		$out->render('web/sidebar.php');
		$out->render('web/tail.php');
	}
	elseif($path[$i + 1] == 'search') {

		/* Web Search */

		$out->title = "Kottu: Search";
		$out->posts = array();
		$out->numblogs	= $k->fetchnumblogs();
		$out->str = '';
	
		/* To make sure links all work */

		$out->lang = 'all';
		$out->time = 'off';
		$out->page = isset($_GET['page']) ? $_GET['page'] : 0;

		if(isset($_GET['q']) && strlen($_GET['q']) > 0) {
	
			$out->posts = $k->search($_GET['q'], $out->page, $path[$i]);
			$out->str	= urldecode($_GET['q']);
			$out->lang	= $path[$i];
			$out->toplink		= "search/?q={$out->str}";
			$out->currentpage	= "{$out->lang}/search/?q={$out->str}&page="; 
		}

		$out->render('web/head.php');
		$out->render('web/items.php');
		$out->render('web/tail.php');
	}
	elseif($path[$i] == 'blog') {
	
		/* start output buffer */
		ob_start();
	
		/* Display posts from one blog */
	
		$out->bid	= $path[$i + 1] != null && strlen($path[$i + 1]) ? $path[$i + 1] : 0;
		$out->blog	= $k->blogdetails($out->bid);
		$out->lang	= 'all';
		$out->time	= 'off';
		$out->pop	= $path[$i + 2] != null && strlen($path[$i + 2]) ? $path[$i + 2] : 'off';
		$out->page	= $path[$i + 3] != null && strlen($path[$i + 3]) ? $path[$i + 3] : 0;
	
		$out->title = "Kottu: Posts from " . $out->blog['name'];
		$out->posts = $k->fetchblogposts($path[$i + 1], $out->page, $out->pop == 'off');

		$out->numblogs	= $k->fetchnumblogs();
		$out->hotposts	= array_slice($k->fetchallposts('all', 'today'), 0, 5);
		$out->trending	= $k->trendingtopics();
		$out->currentpage = "blog/{$out->bid}/{$out->pop}/";

		$out->render('web/head.php');
		$out->render('web/items.php');
		$out->render('web/sidebar.php');
		$out->render('web/tail.php');
		
		/* save contents of buffer into cache file */
		$fp = fopen($cachefile, 'w'); 
		fwrite($fp, ob_get_contents());
		fclose($fp); 

		/* send buffer contents to browser */
		ob_end_flush();
	}
	else {
	
		switch($path[$i]) {
		
			case '':
			case 'all':
			case 'en':
			case 'si':
			case 'ta':
			
				$subpath = isset($path[$i+1]) ? $path[$i+1] : ''; 
		
				switch($subpath) {
				
					case '':
					case 'off':
					case 'today':
					case 'week':
					case 'month':
					case 'all':
					
						break;
						
					default:
						
						include('./templates/web/error.php');
						die();
				}	
	
				/* start output buffer */
				ob_start();

				/* Normal Kottu website */

				$out->lang = isset($path[$i]) && strlen($path[$i]) ? $path[$i] : 'all';
				$out->time = isset($path[$i + 1]) && strlen($path[$i + 1]) ? $path[$i + 1] : 'off';
				$out->page = isset($path[$i + 2]) && strlen($path[$i + 2]) ? $path[$i + 2] : 0;
		
				$out->title =  'Kottu: ' . titlemaker($out->lang, $out->time, $out->page + 1);
				$out->toplink	= $out->time;
				$out->numblogs	= $k->fetchnumblogs();
				$out->posts		= $k->fetchallposts($out->lang, $out->time, $out->page);
				$out->hotposts	= array_slice($k->fetchallposts('all', 'today'), 0, 5);
				$out->trending	= $k->trendingtopics();
				$out->currentpage = "{$out->lang}/{$out->time}/";
				$out->mainpage	= true;

				$out->render('web/head.php');
				$out->render('web/items.php');
				$out->render('web/sidebar.php');
				$out->render('web/tail.php');
		
				/* save contents of buffer into cache file */
				$fp = fopen($cachefile, 'w'); 
				fwrite($fp, ob_get_contents());
				fclose($fp); 

				/* send buffer contents to browser */
				ob_end_flush();
				break;
				
			default:

				include('./templates/web/error.php');
				break;
		}
	}
	
	$janithend = microtime(true);
	
	echo "<!-- Page generated in ", number_format($janithend - $janithstart, 3) , " seconds -->";
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
