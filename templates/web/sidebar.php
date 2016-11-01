<div class="sidebar col-sm-12 col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Trending On Kottu <small>Today</small></h3></div>
		<div class="list-group">
<?php foreach($this->trending as $p): ?>
			<a class="list-group-item" target="_blank" title="Trend: <?= $p['trend'] ?>"
			href="<?php echo config('basepath') . '/go/?id=' . $p['id'] . '&url=' . $p['link']; ?>">
				<?php echo $p['title']; ?>
			</a>
<?php endforeach; ?>
		</div>
		<div class="panel-footer text-center">
			<a class="btn btn-success" title="View posts listed by Kottu most clicked trend" 
				href="<?php echo config('basepath') . '/' . $this->lang . '/trending/';?>">See More →</a>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Hot Posts <small>Today</small></h3></div>
		<div class="list-group">
<?php foreach($this->hotposts as $p): ?>
			<a class="list-group-item" target="_blank" title="PostBuzz: <?= $p['buzz'] ?>"
			href="<?php echo config('basepath') . '/go/?id=' . $p['id'] . '&url=' . $p['link']; ?>">
				<?php echo $p['title']; ?>
			</a>
<?php endforeach; ?>
		</div>
		<div class="panel-footer text-center">
			<a class="btn btn-success" title="View posts listed by social media popularity" 
				href="<?php echo config('basepath') . '/' . $this->lang . '/today/';?>">See More →</a>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Sri Lanka on Flickr</h3></div>
		<div class="panel-body text-center">
		<script type="text/javascript" 
	src="http://www.flickr.com/badge_code_v2.gne?count=5&display=latest&size=m&layout=x&source=all_tag&tag=lanka%2C+srilanka"></script>
		</div>
	</div>

<?php if($this->mainpage === true): ?>
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Grab Page RSS Feed</h3></div>
		<div class="panel-body">
			<p>You can grab an RSS feed of posts that appear on this page</p>
		</div>
		<div class="panel-footer text-center">
			<a class="btn btn-success" href="<?php echo config('basepath') . '/feed/' . $this->lang . '/' . $this->time; ?>" 
				title="Get the rss feed for the page/combination currently selected">Grab Feed →</a>
		</div>
	</div>
<?php endif; ?>
</div>

