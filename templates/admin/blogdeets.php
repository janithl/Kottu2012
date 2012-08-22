
<div class="span9">
  	<form class="form-horizontal" action="<?= config('basepath'); ?>/admin/blogdeetsubmit" method="POST">
	<fieldset>
	<?php if(count($this->eblog) > 0): ?>
	<legend>Editing blog #<?= $this->eblog['id']; ?></legend>	
	<?php else: ?>
	<legend>Add a blog</legend>
	<?php endif; ?>
		<div class="control-group">
		    <?php if(count($this->eblog) > 0): ?>
			<input type="hidden" name="bid" value="<?= $this->eblog['id']; ?>" />		    
		    <?php endif; ?>
			<label class="control-label" for="input01">Blog name</label>
			<div class="controls">
			<input type="text" class="input-xlarge" id="input01" name="bname" 
			<?= (count($this->eblog) > 0) ? ' value="'.$this->eblog['name'].'"': ''; ?>>
			</div>
			<br>
			<label class="control-label" for="input02">Blog URL</label>
			<div class="controls">
			<input type="text" class="input-xlarge" id="input02" name="burl" 
			<?= (count($this->eblog) > 0) ? ' value="'.$this->eblog['url'].'"': ''; ?> onblur="copytorss(this.value)">
			</div>
			<br>
			<label class="control-label" for="input03">Blog RSS</label>
			<div class="controls">
			<input type="text" class="input-xlarge" id="input03" name="brss"
			<?= (count($this->eblog) > 0) ? ' value="'.$this->eblog['feed'].'"': ''; ?>>
			</div>
			
			<div class="form-actions">
			<button class="btn btn-primary" type="submit">
			<?= (count($this->eblog) > 0) ? 'Update Blog' : 'Add Blog' ?></button>
			<button class="btn" type="cancel">Cancel</button>
			</div>
		</div>
	</fieldset>
	</form>
</div><!--/span-->
 

