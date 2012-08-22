<div data-role="content" data-theme="c">
	
	<?php if(count($this->post) > 0): ?>
		<h2><?php echo $this->post['title']; ?></h2>
		<p>Posted on <?php echo $this->post['blog']; ?>  
		<span class="timestamp">(<?php echo $this->post['ts']; ?>)</span>  
		<img src="<?php echo config('basepath'), '/img/icons/chili', $this->post['buzz']; ?>.png"/></p>
		<?php if(strlen($this->post['img']) > 0): ?>
		<p><img src="<?php echo config('basepath'), '/img/?q=80&src=', $this->post['img']; ?>" /></p>
		<?php endif; ?>
		
		<p><?php echo $this->post['cont']; ?></p>
		
		<a data-rel="back" href="./" data-mini="true" data-inline="true" 
		data-icon="arrow-l" data-role="button" >Go back</a>
		
		<a href="<?php echo config('basepath'), '/go/?id=', $this->post['id'], '&url=', $this->post['link']; ?>"
		data-mini="true" data-inline="true" data-iconpos="right" 
		data-icon="arrow-r" data-role="button" data-theme="b" target="_blank">Read full post</a>		
	<?php else: ?>
		<h3>Post not found</h3>
		
		<a data-rel="back" href="./" data-mini="true" data-inline="true" 
		data-icon="arrow-l" data-role="button" >Go back</a>
	<?php endif ?>

</div><!-- /content -->

