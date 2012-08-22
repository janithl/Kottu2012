
<div class="span9">
    
    <legend>PHP errors log</legend>
    <?php if(count($this->entries) == 0): ?>
    <div class="alert alert-info">
    No entries in PHP error log!
    </div>
    <?php else: ?>
    <table class="table table-condensed" id="errorlog">
    <tbody>
    <?php foreach($this->entries as $e): ?>
    <tr><td><?= $e ?></td></tr>
	<?php endforeach; ?>
    </tbody>
  	</table>
    <?php endif; ?>
    
</div><!--/span-->	

