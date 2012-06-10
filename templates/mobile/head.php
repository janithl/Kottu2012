<!DOCTYPE html> 
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title><?php echo $this->title ? $this->title.' - ' : '' ?>Kottu Mobile</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<link rel="icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo config('basepath'); ?>/img/icons/kottu.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo config('basepath'); ?>/feed/" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
	<style type="text/css">
	.ui-li-thumb { top: 7px; left: 7px; }
	.timestamp { color: #999; }
	</style>
</head> 

	
<body> 

<!-- Start of first page: #one -->
<div data-role="page" id="mainpage" data-theme="c">

<div data-role="header" data-position="inline">
	<h1><?php echo $this->title ?></h1>
</div><!-- /header -->

