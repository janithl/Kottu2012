<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title>Kottu: Page Not Found</title>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo config('basepath'); ?>/static/css/style.css">
	<link rel="icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo config('basepath'); ?>/feed/" />
</head>

<body>

<header>
	<nav id="mainmenu" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo config('basepath'); ?>"><img alt="Kottu" title="Go to the Kottu home page" src="<?php echo config('basepath'); ?>/img/icons/logo.png" /></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<p class="navbar-text hidden-sm">syndicates over <a title="View our blogroll" href="<?php echo config('basepath'); ?>/blogroll">1000  
Sri Lankan blogs</a>. You can <a title="Learn more about Kottu and how you can join" href="<?php echo config('basepath'); ?>/about">join too</a>.</p>
				<form class="navbar-form navbar-left" method="GET" action="<?php echo config('basepath') ?>/all/search/">
					<div class="form-group">
						<input tabindex=1 id="searchbar" name="q" type="text" class="form-control" 
						placeholder="Search Kottu..." value="">
					</div>
					<button tabindex=2 id="searchbtn" type="submit" class="btn btn-default">Search</button>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li class="langs"><a class="menuitem" title="View English language posts" href="<?php echo config('basepath') . '/en/'; ?>">English</a></li>
					<li class="langs"><a class="menuitem" title="View Sinhala language posts" href="<?php echo config('basepath') . '/si/'; ?>">සිංහල</a></li>
					<li class="langs"><a class="menuitem" title="View Tamil language posts" href="<?php echo config('basepath') . '/ta/'; ?>">தமிழ்</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
  		</div>
	</nav>
</header>

<div class="container">
<div class="col-xs-12 col-sm-8 col-sm-offset-2">
<div class="content"><!-- content -->

	<article class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">404: Page Not Found</h2>
		</div>
		
		<div class="panel-body text-center">
			<p><img src="<?php echo config('basepath'); ?>/img/bpf.png"/></p>

			<p>The page that you were looking for could not be found. Would you like to search for it instead?</p>

			<form role="search" method="GET" class="searchform" action="<?php echo config('basepath'); ?>/all/search/">
				<div class="input-group">
					<input tabindex=3 type="text" name="q" id="q" class="form-control" placeholder="Search Kottu For...">
					<span class="input-group-btn">
						<button tabindex=4 class="btn btn-default" type="submit">Search!</button>
					</span>
				</div>
			</form>
		</div>
	</article>

</div>
</div>

<?php include(__DIR__ . '/tail.php') ?>