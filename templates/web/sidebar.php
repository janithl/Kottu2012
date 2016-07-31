<div class="sidebar col-sm-12 col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Tags</h3></div>
		<div class="panel-body">
			<span class="tag tagsize2">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/tech/'; ?>">tech</a>
			</span>
			<span class="tag tagsize1">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/nature/'; ?>">nature</a>
			</span>
			<span class="tag tagsize2">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/news/'; ?>">news</a>
			</span>
			<span class="tag tagsize1">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/education/'; ?>">education</a>
			</span>
			<span class="tag tagsize1">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/travel/'; ?>">food/travel</a>
			</span>
			<span class="tag tagsize3">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/sports/'; ?>">sports</a>
			</span>
			<span class="tag tagsize3">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/personal/'; ?>">personal</a>
			</span>
			<span class="tag tagsize1">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/poetry/'; ?>">poetry</a>
			</span>
			<span class="tag tagsize2">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/business/'; ?>">business</a>
			</span>
			<span class="tag tagsize1">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/faith/'; ?>">faith</a>
			</span>
			<span class="tag tagsize2">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/entertainment/'; ?>">arts</a>
			</span>
			<span class="tag tagsize3">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/politics/'; ?>">politics</a>
			</span>
			<span class="tag tagsize2">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/photo/'; ?>">photo</a>
			</span>
			<span class="tag tagsize2">
				<a href="<?php echo config('basepath'), '/', $this->lang, '/tags/other/'; ?>">etc</a>
			</span>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Hot Posts <small>Today</small></h3></div>
		<ul class="list-group">
<?php foreach($this->hotposts as $p): ?>
			<li class="list-group-item">
				<a target="_blank" href="<?php echo config('basepath') . '/go/?id=' . $p['id'] . '&url=' . $p['link']; ?>">
				<?php echo $p['title']; ?></a>
			</li>
<?php endforeach; ?>
		</ul>
		<div class="panel-footer text-center">
			<a class="btn btn-success" title="View posts listed by popularity" 
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

