<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title><?php echo $this->title; ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo config('basepath'); ?>/static/style.css">
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
		<li class="tagline">syndicates over <a href="<?php echo config('basepath'); ?>/blogroll"><?php echo $this->numblogs; ?>
		 Sri Lankan blogs</a>. You can <a href="<?php echo config('basepath'); ?>/about">join too</a>.</li>
		
		<li class="langs"><a class="menuitem<?php echo ($this->lang == 'ta') ? ' selected' : ''?>" href="<?php echo config('basepath') . '/ta/' . $this->time; ?>">தமிழ்</a></li>
		<li class="langs"><a class="menuitem<?php echo ($this->lang == 'si') ? ' selected' : ''?>" href="<?php echo config('basepath') . '/si/' . $this->time; ?>">සිංහල</a></li>
		<li class="langs"><a class="menuitem<?php echo ($this->lang == 'en') ? ' selected' : ''?>" href="<?php echo config('basepath') . '/en/' . $this->time; ?>">English</a></li>
		</ul>
	</div>
</header>

<div class="page">
