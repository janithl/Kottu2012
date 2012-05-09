<div data-role="content" data-theme="c">
	
	<?php if(count($this->post) > 0): ?>
		<h3>Posted on <?php echo $this->post['blog']; ?></h3>
		<p class="timestamp">Posted <?php echo $this->post['ts']; ?> . 
		<img src="<?php echo $this->post['buzz']; ?>"/></p>
		<?php if(strlen($this->post['img']) > 0): ?>
		<p><img src="../thumbnails/img.php?q=80&src=<?php echo $this->post['img']; ?>" /></p>
		<?php endif; ?>
		
		<p><?php echo $this->post['cont']; ?></p>
		
		<a href="./" data-mini="true" data-inline="true" data-icon="arrow-l" 
		data-role="button" >Go back</a>
		
		<a href="../go.php?pid=<?php echo $this->post['id']; ?>&url=<?php echo $this->post['link']; ?>"
		data-mini="true" data-inline="true" data-iconpos="right" 
		data-icon="arrow-r" data-role="button" data-theme="b" target="_blank">Read full post</a>		
	<?php else: ?>
		<h3>Post not found</h3>
		
		<a href="./" data-mini="true" data-inline="true" data-icon="arrow-l" 
		data-role="button" >Go back</a>
	<?php endif ?>

</div><!-- /content -->

