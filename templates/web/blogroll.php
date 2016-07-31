<div class="col-sm-12 col-md-8">
<div class="content"><!-- content -->

	<article class="panel panel-default">
		<div class="panel-heading"><h2 class="panel-title">Blogroll</h2></div>
		<div class="panel-body">
			<p>This is a list of all the blogs currently syndicated on kottu.org. 
			To add your (Sri Lankan) blog just email indi@indi.ca</p>
		</div>
		<ul class="list-group">
<?php foreach($this->blogs as $b): ?>
				<li class="list-group-item"><a href="<?php echo config('basepath') , '/blog/' , $b['bid']; ?>"><?php echo $b['name']; ?></a></li>
<?php endforeach; ?>
		</ul>
	</article>
</div>
</div>

<div class="sidebar col-sm-12 col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Popular Blogs <small>(Last 30 days)</small></h3></div>
		<div class="list-group">
<?php foreach($this->popblogs as $pb): ?>
			<a href="<?php echo config('basepath') , '/blog/' , $pb['bid']; ?>" class="list-group-item">
				<h4 class="list-group-item-heading"><?php echo $pb['name']; ?></h4>
				<p class="list-group-item-text">Last Updated: <?php echo $pb['lupdt']; ?><br>
		Average: <img title="Average post popularity is <?php echo $pb['buzz']; ?> chilies"
		src="<?php echo config('basepath') , '/img/icons/chili' , $pb['buzz']; ?>.png" alt="<?php echo $pb['buzz']; ?> chilies"/></p>
			</a>
<?php endforeach; ?>
		</div>
	</div>
</div>

