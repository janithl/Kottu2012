<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title><?php echo $this->title; ?></title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abhaya+Libre:400,500&amp;subset=latin-ext,sinhala"> 
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
				<p class="navbar-text hidden-sm"><strong class="visible-xs-inline">Kottu </strong>syndicates over <a title="View our blogroll" href="<?php echo config('basepath'); ?>/blogroll"><?php echo $this->numblogs; ?> 
Sri Lankan blogs</a>. You can <a title="Learn more about Kottu and how you can join" href="<?php echo config('basepath'); ?>/about">join too</a>.</p>
				<form class="navbar-form navbar-left" method="GET" action="<?php echo config('basepath'),'/',$this->lang; ?>/search/">
					<div class="form-group">
						<input tabindex=1 id="searchbar" name="q" type="text" class="form-control" 
						placeholder="Search Kottu..." value="<?= $this->title == "Kottu: Search" ? $this->str : '' ?>">
					</div>
					<button tabindex=2 id="searchbtn" type="submit" class="btn btn-default">Search</button>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li class="langs<?php echo ($this->lang == 'en') ? ' active' : ''?>"><a class="menuitem" title="View English language posts" href="<?php echo config('basepath') . '/en/' . $this->toplink; ?>">English</a></li>
					<li class="langs<?php echo ($this->lang == 'si') ? ' active' : ''?>"><a class="menuitem" title="View Sinhala language posts" href="<?php echo config('basepath') . '/si/' . $this->toplink; ?>">සිංහල</a></li>
					<li class="langs<?php echo ($this->lang == 'ta') ? ' active' : ''?>"><a class="menuitem" title="View Tamil language posts" href="<?php echo config('basepath') . '/ta/' . $this->toplink; ?>">தமிழ்</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
  		</div>
	</nav>
</header>

<div class="container">
