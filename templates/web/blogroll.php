<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
		"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Kottu: About/Join</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo config('basepath'); ?>/static/yoko.css" />
	<link rel="icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<!--[if lt IE 9]>
	<script src="../js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('basepath'); ?>/static/js/smoothscroll.js?ver=1.0"></script>

	<style type="text/css">
	#popblogs a { color: #600; }
	#popblogs strong { font-weight: bold; }
	.entry-content a { color: #600; }
	</style>
</head>
<body class="home blog">
<div id="page" class="clearfix">
	<header id="branding">
	<nav id="mainnav" class="clearfix">

	<div class="menu-page-menu-container">
	<ul id="menu-page-menu" class="menu">
		<li class="menu-item"><a href="<?php echo config('basepath'); ?>/about">About/Join</a></li>
		<li class="menu-item selected"><a href="<?php echo config('basepath'); ?>/blogroll">Blogroll</a></li>
	</ul>
	</div>
	</nav><!-- end mainnav -->

	<hgroup id="site-title">
		<h1><a href="<?php echo config('basepath'); ?>" title="Kottu">Kottu</a></h1>
		<h2 id="site-description">syndicates 
		<a href="<?php echo config('basepath'); ?>/blogroll"><?php echo count($this->blogs); ?> Sri Lankan blogs</a>. 
		You can <a href="<?php echo config('basepath'); ?>/about">join too</a>.</h2>
	</hgroup><!-- end site-title -->
	<div class="clear"></div>

</header><!-- end header -->
<div id="wrap">

<div id="content">

<article class="post type-post status-publish format-standard hentry">

	<div class="entry-details">

	</div><!-- end entry-details -->
	 
	<header class="entry-header">
	<h2 class="entry-title">Blogroll</h2>
	</header><!-- end entry-header -->
        
	<div class="entry-content">
	<p>This is a list of all the blogs currently syndicated on kottu.org. 
	To add your (Sri Lankan) blog just email indi@indi.ca</p>
	<ul>
<?php foreach($this->blogs as $b): ?>
	<li><a href="<?php echo $b['link']; ?>" target="_blank"><?php echo $b['name']; ?></a></li>
<?php endforeach; ?>
	</ul>
	</div>
</article>
</div><!-- end content -->

<div id="tertiary" class="widget-area" role="complementary">
<aside id="popblogs" class="widget widget_recent_entries">
<h3 class="widget-title">Popular Blogs (Last 30 days)</h3>
	<ul>
<?php foreach($this->popblogs as $pb): ?>
	<li><a href=""></a></li>
	<li>
		<a href="<?php echo $pb['link']; ?>" target="_blank">
		<strong><?php echo $pb['name']; ?></strong></a><br>
		Last Updated: <?php echo $pb['lupdt']; ?><br>
		Average: <?php echo config('basepath') . "/img/icons/" . $pb['buzz']; ?>
	</li>
<?php endforeach; ?>	
	</ul>
</aside>
</div><!-- end tertiary .widget-area -->

</div><!-- end wrap -->

<footer id="colophon" class="clearfix">
	Theme: Yoko by <a href="http://www.elmastudio.de/wordpress-themes/">Elmastudio</a><br>
	<a href="#page" class="top">Top</a>
</footer><!-- end colophon -->

</div>
</body>
</html>
