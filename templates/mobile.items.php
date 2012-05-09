<div data-role="content" data-theme="c">	

	<ul data-role="listview">
	
	<?php if(count($this->posts) > 0): ?>
		<?php foreach($this->posts as $i): ?>
		<li>
			<a href="./?post=<?php echo $i['id']; ?>">
			<img src="../thumbnails/img.php?q=80&src=<?php echo $i['img']; ?>" />
			<h3><?php echo $i['title']; ?></h3>
			<p><?php echo $i['blog']; ?> <span class="timestamp">
				(<?php echo $i['ts']; ?>)</span>
			</p>
			<p><img src="<?php echo $i['buzz']; ?>"/></p>
			</a>
		</li>
		<?php endforeach ?>	
	<?php else: ?>
		<li><h3>No items to display</h3></li>
	<?php endif; ?>
		
	</ul>	

</div><!-- /content -->
	

