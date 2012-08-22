<div class="sidebar">
	<div class="widgetheader widgetfirst">Search</div>
	<div class="widgetcont">
	<form role="search" method="get" class="searchform" action="<?php echo config('basepath'),'/',$this->lang; ?>/search/" >
	<input tabindex=1 type="text" class="searchbox" value="<?php echo $this->str; ?>" name="q" id="q" />
	<input tabindex=2 type="submit" class="searchsubmit" value="Search" title="Search" />
	</form>
	</div>
	
	<div class="widgetheader">Tags</div>
	<div class="widgetcont">
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
	
	<div class="widgetheader">Hot Posts</div>
	<div class="widgetcont">
	<ul>
<?php foreach($this->hotposts as $p): ?>
	<li>
		<a target="_blank" href="<?php echo config('basepath') . '/go/?id=' . $p['id'] . '&url=' . $p['link']; ?>">
		<?php echo $p['title']; ?></a>
	</li>
<?php endforeach; ?>
	</ul>
	<div class="hotlink"><a title="View posts listed by popularity" href="<?php echo config('basepath') . '/' . $this->lang . '/today/';?>">read more →</a></div>
	</div>
	
	<div class="widgetheader">Sri Lanka on Flickr</div>
	<div class="widgetcont">
	<script type="text/javascript" 
src="http://www.flickr.com/badge_code_v2.gne?count=5&display=latest&size=m&layout=x&source=all_tag&tag=lanka%2C+srilanka"></script>
	<div class="clear"></div>
	</div>
	
	<div class="widgetheader">Encourage Them!</div>
	<div class="widgetcont" id="encourage">
	<p>These are young bloggers from eVillages throughout the country. Please 
	comment to encourage them to blog more.</p><br>
	<script type="text/javascript">
	var blogcontent=new Array();

	blogcontent[0]='<img src="<?php echo config('basepath'); ?>/img/banner.png"/>';
	<?php $count = 0; ?>
	<?php foreach($this->evillage as $e): ?>
	
	blogcontent[<?php echo ++$count, "]='<strong><a href=\"", $e['link'] ,'" target="_blank">', 
	$e['title'], '</a></strong><br>', $e['cont'],
	'<br><br>(<a href="', $e['link'], '" target="_blank">read more</a>)\';'; ?>
	
	<?php endforeach; ?>
	new pausescroller(blogcontent, "encourage", "someclass", 5000);
	</script>
	<div class="clear"><br></div>
	</div>
	<div class="widgetcont">
	<br>
	</div>
	
<?php if($this->mainpage === true): ?>
	<div class="widgetcont">
	<br>
	<div class="hotlink"><a href="<?php echo config('basepath') . '/feed/' . $this->lang . '/' . $this->time; ?>" 
		title="Get the rss feed for the page/combination currently selected">grab page rss feed →</a></div>
	<div class="clear"></div>
	</div>
<?php endif; ?>
</div>

