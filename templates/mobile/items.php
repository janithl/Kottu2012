<div data-role="content" data-theme="c">	

	<ul data-role="listview">
	
	<?php if(count($this->posts) > 0): ?>
		<?php foreach($this->posts as $i): ?>
		<li>
			<a href="./?post=<?php echo $i['id']; ?>">
			<img src="<?php echo config('basepath') . '/img/?q=80&src=' . $i['img']; ?>" />
			<h3><?php echo $i['title']; ?></h3>
			<p><?php echo $i['blog']; ?> <span class="timestamp">
				(<?php echo $i['ts']; ?>)</span>
			</p>
			<p><img src="<?php echo config('basepath') . '/img/icons/chili' . $i['buzz']; ?>.png"/></p>
			</a>
		</li>
		<?php endforeach ?>
		<li><a href="<?php echo $this->next; ?>"><h3>View older posts</h3></a></li>
	<?php else: ?>
		<li><h3>No items to display</h3></li>
	<?php endif; ?>
		
	</ul>	

</div><!-- /content -->
	

