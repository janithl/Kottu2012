<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title><?php echo $this->title; ?></title>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo config('basepath'); ?>/static/css/style.css">
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo config('basepath'); ?>/static/css/ie8.css">
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
		<li><a href="<?php echo config('basepath'); ?>"><img alt="Kottu" title="Go to the Kottu home page" src="<?php echo config('basepath'); ?>/img/icons/logo.png" /></a></li>
		<li class="tagline">syndicates over <a title="View our blogroll" href="<?php echo config('basepath'); ?>/blogroll"><?php echo $this->numblogs; ?>
		 Sri Lankan blogs</a>. You can <a title="Learn more about Kottu and how you can join" href="<?php echo config('basepath'); ?>/about">join too</a>.</li>
		
		<li class="langs"><a class="menuitem<?php echo ($this->lang == 'ta') ? ' selected' : ''?>" title="View Tamil language posts" href="<?php echo config('basepath') . '/ta/' . $this->toplink; ?>">தமிழ்</a></li>
		<li class="langs"><a class="menuitem<?php echo ($this->lang == 'si') ? ' selected' : ''?>" title="View Sinhala language posts" href="<?php echo config('basepath') . '/si/' . $this->toplink; ?>">සිංහල</a></li>
		<li class="langs"><a class="menuitem<?php echo ($this->lang == 'en') ? ' selected' : ''?>" title="View English language posts" href="<?php echo config('basepath') . '/en/' . $this->toplink; ?>">English</a></li>
		</ul>
	</div>
</header>

<div class="page">
