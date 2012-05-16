
<div class="content">

	<article class="post">
	<div class="postheader">
		<h2 class="posttitle">Blogroll</h2>
	</div>
        
	<div class="postcont">
	<p>
	This is a list of all the blogs currently syndicated on kottu.org. 
	To add your (Sri Lankan) blog just email indi@indi.ca
	<ul>
<?php foreach($this->blogs as $b): ?>
	<li><a href="<?php echo $b['link']; ?>" target="_blank"><?php echo $b['name']; ?></a></li>
<?php endforeach; ?>
	</ul>
	</p>
	</div>
	</article>
</div>

<div class="sidebar">
	<div class="widgetheader widgetfirst">Popular Blogs (Last 30 days)</div>
	<div class="widgetcont">
	<ul>
<?php foreach($this->popblogs as $pb): ?>
	<li>
		<a href="<?php echo $pb['link']; ?>" target="_blank">
		<strong><?php echo $pb['name']; ?></strong></a><br>
		Last Updated: <?php echo $pb['lupdt']; ?><br>
		Average: <img src="<?php echo config('basepath') . '/img/icons/' . $pb['buzz']; ?>"/>
	</li>
<?php endforeach; ?>	
	</ul>
	</div>
</div>

