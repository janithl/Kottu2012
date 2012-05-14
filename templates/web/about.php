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
</head>
<body class="home blog">
<div id="page" class="clearfix">
	<header id="branding">
	<nav id="mainnav" class="clearfix">

	<div class="menu-page-menu-container">
	<ul id="menu-page-menu" class="menu">
		<li class="menu-item selected"><a href="<?php echo config('basepath'); ?>/about">About/Join</a></li>
		<li class="menu-item"><a href="<?php echo config('basepath'); ?>/blogroll">Blogroll</a></li>
	</ul>
	</div>
	</nav><!-- end mainnav -->

	<hgroup id="site-title">
		<h1><a href="<?php echo config('basepath'); ?>" title="Kottu">Kottu</a></h1>
		<h2 id="site-description">The Sri Lankan Blog Aggregator</h2>
	</hgroup><!-- end site-title -->
	<div class="clear"></div>

</header><!-- end header -->
<div id="wrap">

<div id="content">

<article class="post type-post status-publish format-standard hentry">

	<div class="entry-details">

	</div><!-- end entry-details -->
	 
	<header class="entry-header">
	<h2 class="entry-title">About/Join</a></h2>
	</header><!-- end entry-header -->
        
	<div class="entry-content">
	<p>Kottu is a Sri Lankan blog aggregator. It basically collects a slice of 
	the Sri Lankan blogosphere in one place. The only criteria for joining Kottu is:</p>
	<ol>
	<li>Having a working feed (which most blogs do)</li>
	<li>Being ‘Sri Lankan’, as in based in or covering Sri Lankan experiences</li>
	<li>Being original content (not copy/pasted)</li>
	<li>Observing very basic standards of libel and obscenity</li>
	<li>Being updated in the last two month</li>
	</ol>
	<p>To join just send a mail to indi@indi.ca. I’ll get around to a contact form someday.</p>
	<h3>What Is Kottu?</h3>
	<p>Kottu reads a bunch of Sri Lankan blogs and posts summaries, basically. If you’re 
	unfamiliar, a feed is something a blog has. If you’re unfamiliar with a blog, click some 
	of the links on Kottu. It’s basically a personal webpage updated frequently. Every modern 
	blog has a feed. As a blogger this can be irrelevant, but feeds are a standard that 
	allow you to play with data in a lot of fun ways. Basically, you can have hundreds of 
	blogs that look and behave different, but the feeds are all standard. That means Kottu, 
	as a machine, can read them all.</p>
	<p>Kottu is, physically, a rented Rackspace Cloud server running Linux and a basic set 
	of software. <s>One program it runs is WordPress, which is a blogging software itself</s>.
	 This makes Kottu a sort of metablog. Instead of a writer, however, Kottu reads hundreds
	  of feeds and posts summaries. You can click on the links to read the original content
	  on those sites. It also ‘reads’ the feeds from Flickr to find Sri Lankan photos.</p>
	<p>There is a lot of technical wizardry behind this, <s>but that is all managed by a 
	WordPress plugin called FeedWordpress</s>. Setting up Kottu from scratch (now) takes 
	about 15 minutes and is pretty easy to replicate. Kottu involves almost no original 
	code, but rather putting existing pieces together.</p>
	<h3>Who Is Kottu?</h3>
	<p>Kottu – the name and spur – came from Mahangu. The data structure was imagined by 
	Indi Samarajiva, but it’s not especially originally. It is actually something called 
	a ‘Planet’, used by geeks for years. Mahangu is in Uni and not much in the Blogging 
	scene, but Indi is still an active blogger at www.indi.ca. Kottu was recoded in 
	August 2011 by Janith Leanage and he's now the main Kottu cooker.</p>

	<p>Indi, that is I, am basically the janitor. I add feeds, I keep an eye on the 
	database, and generally try to keep the place clean. I do have opinions – which 
	I write on indi.ca – but they have no bearing on Kottu. I’m not saint, but I am 
	lazy and it is easy for me to simply syndicate everyone that fits the requirements 
	above without thinking too much about it. I’m sorry that there’s still a human 
	element here, but there is. I cannot be assed to be any sort of active figure, 
	I’m just trying to keep the place clean.</p>
	<h3>Concerning the requirements:</h3>
	<ol>
	<li>Valid Feed: Basically if you don’t have an RSS or Atom or RDF feed, Kottu 
	can’t syndicate you. It just technically doesn’t work. You don’t need to know 
	what these things are, they come with any modern blog (as listed below).</li>
	<li>Sri Lankan Content: Kottu isn’t a random aggregator, it’s Sri Lankan. That 
	can mean you’re in Sri Lanka, or abroad talking about it, or whatever. This 
	also, by extension, means that overly technical blogs won’t be syndicated because 
	they’re not exactly great for a general Sri Lankan audience. This is obviously a 
	grey area, but blogs 95% devoted to coding or gaming probably won’t fit.</li>
	<li>Original Content: Basically, copying and pasting from newspapers or online 
	sources doesn’t count as a blog post. It’s fine copying a quote or paragraphs of 
	interesting text/image/video and then commenting on it, but what Kottu is interested 
	in is your commentary.</li>
	<li>Libel and Obscenity: The blogging scene is pretty diverse, so please try to 
	think of the community. The occasional ‘fuck’ or ’shit’ is fine, but basically 
	stuff that would totally gross my mother out is not cool. That is, admitedly, a 
	pretty obscure standard, but what to do. In terms of libel, it’s basically not 
	cool to personally attack people to the point of (seriously) threatening violence 
	or publishing phone numbers, addresses, and revealing anonymous identities. There 
	is a lot of rough and tumble on Kottu, but there is a grey line.</li>
	<li>Being Updated In The Last Two Months: Kottu polls the feeds, and it’s not 
	efficient to poll dead ones. If you haven’t updated in the last two months, you 
	will be dropped – without notification. This is not to be an ass, I probably 
	just don’t have your email handy and am actually doing this in my limited spare time.</li>
	</ol>
	<h3>ETC</h3>

	<p>Basically, as the janitor, I am busy and I do and pay for this in my spare 
	time. I can’t always respond to email fast, and I sometimes forget to respond 
	at all. I can’t fix your blog and I can only go so far towards resolving problems. 
	I care about Kottu, but this is not a public or even private service and you simply 
	can’t expect very good ‘customer service’. I have a day job and family and life 
	and this is something I look after when I can, so please try to be understanding.</p>
	<p>At some point I hope to hand over the admin of Kottu and go a bit open-source, 
	but that’s kinda how it is right now. Anyways, welcome and happy blogging.</p>
	<h3>Recommendations</h3>
	<p>If you want to start blogging I wholeheartedly recommend wordpress.com. 
	It’s fully hosted and sets up in minutes. Another big service is Blogger, 
	which is very popular and owned by Google. If you want total control, 
	wordpress.org is what runs Kottu and it’s pretty simple and powerful. 
	You do need to rent a server for that. Kottu runs on a Rackspace Cloud Server, 
	but that’s not necessarily a recommendation.</p>
	</div><!-- end entry-content -->
			
</article>

</div>
</div>

<footer id="colophon" class="clearfix">
	Theme: Yoko by <a href="http://www.elmastudio.de/wordpress-themes/">Elmastudio</a><br>
	<a href="#page" class="top">Top</a>
</footer><!-- end colophon -->

</div>
</body>
</html>
