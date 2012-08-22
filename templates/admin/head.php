<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?= $this->title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?= config('basepath'); ?>/static/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">

      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="<?= config('basepath'); ?>/static/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel="icon" href="<?= config('basepath'); ?>/img/icons/kadmin.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?= config('basepath'); ?>/img/icons/kadmin.ico" type="image/x-icon" />
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?= config('basepath'); ?>/admin">Kottu Baas</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?= $this->username; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?= BASEPATH, '/logout'; ?>">Sign Out</a></li>
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
                <li<?php if($this->page == "")          { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin">Home</a></li>
                <li<?php if($this->page == "modify")    { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin/modify">Modify Blogs</a></li>
                <li><a onclick="window.open('<?= config('basepath') ?>/admin/addblog', '','toolbar=no,scrollbars=yes,width=500,height=500');" 
                href="#">Add a Blog</a></li>
                <li<?php if($this->page == "stats")   	{ echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin/stats">Stats</a></li>
                <li<?php if($this->page == "logview")   { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin/logview">View Error Logs</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Blog Actions</li>
              <li<?php if($this->page == "")        { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin"><i class="icon-home"></i>Home</a></li>
              <li<?php if($this->page == "approve") { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin/approve"><i class="icon-ok-circle"></i>Join requests</a></li>
              <li<?php if($this->page == "modify")  { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin/modify"><i class="icon-pencil"></i>Modify blogs</a></li>
              <li<?php if($this->page == "trash")   { echo ' class="active" '; } ?>><a href="<?= config('basepath'); ?>/admin/trash"><i class="icon-trash"></i>Deleted blogs</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
