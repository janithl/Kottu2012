<div data-role="content" data-theme="c">

		<div class="content-primary">	
			<ul data-role="listview">
				<?php foreach($this->blogs as $b): ?>
				<li><a href="<?php echo $b['link']; ?>" target="_blank">
					<?php echo $b['name']; ?>
				</a></li>
				<?php endforeach; ?>
			</ul>
		</div><!--/content-primary -->

</div><!-- /content -->
	

