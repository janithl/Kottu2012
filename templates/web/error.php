<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title>Kottu: Page Not Found</title>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo config('basepath'); ?>/static/style.css">
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo config('basepath'); ?>/static/ie8.css">
	<![endif]-->
	<link rel="icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo config('basepath'); ?>/feed/" />
	<script type="text/javascript" src="<?php echo config('basepath'); ?>/static/js/scroller.js"></script>
</head>

<body>

<header>
	<div class="mainmenu">
		<ul>
		<li><a href="<?php echo config('basepath'); ?>"><img alt="Kottu" src="<?php echo config('basepath'); ?>/img/icons/logo.png" /></a></li>
		<li class="tagline">syndicates over <a href="<?php echo config('basepath'); ?>/blogroll">1000
		 Sri Lankan blogs</a>. You can <a href="<?php echo config('basepath'); ?>/about">join too</a>.</li>
		
		<li class="langs"><a class="menuitem" href="<?php echo config('basepath') . '/ta/'; ?>">தமிழ்</a></li>
		<li class="langs"><a class="menuitem" href="<?php echo config('basepath') . '/si/'; ?>">සිංහල</a></li>
		<li class="langs"><a class="menuitem" href="<?php echo config('basepath') . '/en/'; ?>">English</a></li>
		</ul>
	</div>
</header>

<div class="page">

<div class="content">

	<article class="post">
	<div class="postheader">
		<h2 class="posttitle">404: Page Not Found</h2>
	</div>
	
	<div class="postcont">
	<p style="text-align:center;">
	<img src="<?php echo config('basepath'); ?>/img/bpf.png"/><br>
	
	The page that you were looking for could not be found. Would you like to search for it instead?<br><br>
	
	<form role="search" method="get" class="searchform" action="<?php echo config('basepath'); ?>/all/search/" >
	<input tabindex=1 type="text" class="searchbox" name="q" id="q" />
	<input tabindex=2 type="submit" class="searchsubmit" value="Search" />
	</form>
	</p>
	<br>
	</div>
	
	</article>

</div>
<div class="clear"></div>

<footer>
	<ul class="footermenu">
	<li><a href="https://github.com/janithl/Kottu2012" title="Github: Kottu source code">Source Code</a></li>
	<li><a href="http://my.statcounter.com/project/standard/stats.php?project_id=610934&guest=1" title="Site stats">Stats</a></li>
	<li><a href="<?php echo config('basepath'); ?>/feed/" title="RSS 2.0 feed for latest posts">Latest Posts <small>(RSS 2.0)</small></a></li>
	<li><a href="<?php echo config('basepath'); ?>/feed/all/today" title="RSS 2.0 feed for popular posts">Popular Posts <small>(RSS 2.0)</small></a></li> 
	<li><a href="<?php echo config('basepath'); ?>/about">About/Join</a></li>
	<li><a href="<?php echo config('basepath'); ?>/blogroll">Blogroll</a></li>
	</ul>
</footer>

</div><!-- end page -->

<!-- Start of StatCounter Code -->
<script type="text/javascript" language="javascript">
var sc_project=610934; 
var sc_invisible=0; 
var sc_partition=4; 
var sc_security="0af09d7d"; 
</script>

<script type="text/javascript" language="javascript" src="http://www.statcounter.com/counter/counter.js">
</script>

<!-- End of StatCounter Code -->

<script src="http://www.google-analytics.com/urchin.js" type="­tex­t/­javas­cript"></script>
<script type="­tex­t/­javas­cript"  type="text/javascript" language="javascript">
_uacct = "UA-182033-5";
urch­in­Track­er­();
</script>

</body>
</html>
