<div class="content">
<?php if($this->title == "Kottu: Search"): ?>
	<article class="post">
	<form role="search" method="get" class="searchform" action="<?php echo config('basepath'); ?>/search/" >
	<label for="q">Search: </label>
	<input tabindex=1 type="text" class="searchbox" value="<?php echo $this->str; ?>" name="q" id="q" />
	<input tabindex=2 type="submit" class="searchsubmit" value="Search" />
	</form>
	</article>
<?php endif; ?>

<?php if($this->time != 'off'): ?>
	<article class="post">
	<div class="timemenu">
	<ul>
	<li class="first">Hot: </li>
	<li <?php echo ($this->time == 'today') ? 'class="selected"' : ''?>>
	<a href="<?php echo config('basepath') . '/' . $this->lang . '/today/'; ?>">Today</a></li>
	<li <?php echo ($this->time == 'week')  ? 'class="selected"' : ''?>>
	<a href="<?php echo config('basepath') . '/' . $this->lang . '/week/'; ?>">This Week</a></li>
	<li <?php echo ($this->time == 'month') ? 'class="selected"' : ''?>>
	<a href="<?php echo config('basepath') . '/' . $this->lang . '/month/'; ?>">This Month</a></li>
	</ul>
	</div>
	</article>
<?php endif; ?>


<?php if(count($this->posts) > 0): ?>
	<?php foreach($this->posts as $i): ?>
	<article class="post">
	<div class="postheader">
		<h2 class="posttitle">
		<a href="<?php echo config('basepath') . '/go/?id=' . $i['id'] . '&url=' . $i['link']; ?>" name="<?php echo $i['id']; ?>"><?php echo $i['title']; ?></a>
		</h2>
		<a href="#"><?php echo $i['blog']; ?></a> 
	</div>
	
	<div class="postcont">
			<p>
			<?php if($i['img'] !== config('basepath').'/img/none.png'): ?>
			<span class="thumbnail"><img width="100px" src="<?php echo $i['img']; ?>"/></span>
			<?php endif; ?>
			<?php echo strip_tags(str_replace("\n", " ", $i['cont'])); ?>
			</p>
	</div>
	
	<div class="postfooter">
	<ul>
		<li><span class="timestamp"><?php echo $i['ts']; ?></span></li>
		<li><a href="#" onClick="window.open('http://www.facebook.com/share.php?u=<?php echo $i['link']; ?>', 'Share on Facebook', 
		'toolbar=no, scrollbars=yes, width=500, height=400');" title="This post was liked/shared <?php echo $i['fb']; ?> time(s)" 
		class="share fb"><span>Shares: <?php echo $i['fb']; ?></span></a></li>
		<li><a href="#" onClick="window.open('https://twitter.com/intent/tweet?source=tweetbutton&url=<?php echo $i['link']; ?>', 'Share on Twitter',
		'toolbar=no, scrollbars=yes, width=500, height=400');" title="This post was tweeted <?php echo $i['tw']; ?> time(s)" 
		class="share tw"><span>Tweets: <?php echo $i['tw']; ?></span></a></li>						
		<li><span class="chili"><img src="<?php echo config('basepath') . '/img/icons/' . $i['buzz']; ?>"/></span></li>
	</ul>
	</div>
	</article>
	<?php endforeach; ?>
	
	<?php if($this->title == "Kottu: Search"): ?>
		<a href="<?php echo config('basepath') . '/search/?q=' . $this->str . '&page=' . ($this->page + 1); ?>">
		Previous Page</a>
		<?php if($this->page > 0): ?>
		<span style="float:right;">
		<a href="<?php echo config('basepath') . '/search/?q=' . $this->str . '&page=' . ($this->page - 1); ?>">
		Next Page</a></span>
		<?php endif; ?>
		
	<?php else: ?>
		<a href="<?php echo config('basepath') . '/' . $this->lang . '/' . $this->time . '/' . ($this->page + 1); ?>">
		Previous Page</a>
		<?php if($this->page > 0): ?>
		<span style="float:right;">
		<a href="<?php echo config('basepath') . '/' . $this->lang . '/' . $this->time . '/' . ($this->page - 1); ?>">
		Next Page</a></span>
		<?php endif; ?>
		
	<?php endif; ?>
<?php else: ?>
	<article class="post">
	<div class="postheader">
		<h2 class="posttitle">No items to display</h2>
	</div>
	</article>
<?php endif; ?>

</div>
