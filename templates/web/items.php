<div class="col-sm-12 col-md-8">
<div class="content"><!-- content -->

<?php if(isset($this->blog['url'])): ?>
	<article class="panel panel-default"><!-- blog's post listing -->
		<div class="panel-heading">
			<a href="<?php echo $this->blog['url']; ?>" target="_blank">
				<h3 class="panel-title">
					<?php echo $this->blog['name']; ?> <small>(<?php echo $this->blog['url']; ?>)</small>
				</h3>
			</a>
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills">
				<li role="presentation" <?php echo ($this->pop == 'off') ? 'class="active"' : ''?>>
					<a href="<?php echo config('basepath') . '/blog/' . $this->bid; ?>">Latest Posts</a>
				</li>
				<li role="presentation" <?php echo ($this->pop == 'popular')  ? 'class="active"' : ''?>>
					<a href="<?php echo config('basepath') . '/blog/' . $this->bid . '/popular/'; ?>">Most Popular Posts</a>
				</li>
			</ul>
		</div>
		<div class="panel-footer">
			<button class="btn btn-link btn-ts">Last Updated: <?php echo $this->blog['ts']; ?></button>
			<button class="btn btn-link btn-ts"><?php echo $this->blog['count']; ?> posts on Kottu</button>
			<button class="btn btn-link btn-ts">Average Spice: <img title="Average post popularity is <?php echo $this->blog['buzz']; ?> chilies"
		src="<?php echo config('basepath') , '/img/icons/chili' , $this->blog['buzz']; ?>.png" alt="<?php echo $this->blog['buzz']; ?> chilies"/>
			</button>
		</div>
	</article>
<?php endif; ?>

<?php if($this->time == 'today' || $this->time == 'week' || $this->time == 'month' || $this->time == 'all'): ?>
	<article class="panel panel-default"><!-- popular post timescale selector -->
		<div class="panel-body">
			<ul class="nav nav-pills">
  				<li role="presentation" class="disabled"><a>Hot Posts: </a></li>
				<li role="presentation" <?php echo ($this->time == 'today') ? 'class="active"' : ''?>>
					<a href="<?php echo config('basepath') . '/' . $this->lang . '/today/'; ?>">Today</a>
				</li>
				<li role="presentation" <?php echo ($this->time == 'week')  ? 'class="active"' : ''?>>
					<a href="<?php echo config('basepath') . '/' . $this->lang . '/week/'; ?>">This Week</a>
				</li>
				<li role="presentation" <?php echo ($this->time == 'month') ? 'class="active"' : ''?>>
					<a href="<?php echo config('basepath') . '/' . $this->lang . '/month/'; ?>">This Month</a>
				</li>
				<li role="presentation" <?php echo ($this->time == 'all') ? 'class="active"' : ''?>>
					<a href="<?php echo config('basepath') . '/' . $this->lang . '/all/'; ?>">All Time</a>
				</li>
			</ul>
		</div>
	</article>
<?php endif; ?>


<?php if(count($this->posts) > 0): ?>
	<?php foreach($this->posts as $i): ?>
	<?php include(__DIR__ . '/article.php')  ?>
	<?php endforeach; ?>

	<nav>
		<ul class="pager">
			<li class="previous">
				<a href="<?= config('basepath') . '/' . $this->currentpage . ($this->page + 1) ?>"><span aria-hidden="true">&larr;</span> Previous Page</a>
			</li>

			<li class="next<?= $this->page > 0 ? '' : ' disabled' ?>">
				<a href="<?=  $this->page > 0 ? (config('basepath') . '/' . $this->currentpage . ($this->page - 1)) : '#' ?>">Next Page <span aria-hidden="true">&rarr;</span></a>
			</li>
		</ul>
	</nav>

<?php else: ?>
	<div class="jumbotron text-center"><p class="lead">No items to display</p></div>
<?php endif; ?>

</div>
</div>
