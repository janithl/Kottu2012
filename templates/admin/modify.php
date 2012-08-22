
<div class="span9">
    <legend><?= ($this->undelete) ? "Deleted Blogs" : "Modify Blogs"; ?></legend>
    <?php if(count($this->blogs) == 0): ?>
    <div class="alert alert-info">
    No blogs here!
    </div>
    <?php else: ?>
	<?php if(!$this->undelete): ?>
		<div class="pull-right">
		<form action="<?= config('basepath') ?>/admin/modify/" method="GET">
		<fieldset>
		<div class="control-group">
		<input type="text" name="search" class="input" placeholder="Search…" id="modsearch">
		</div>
		</fieldset>
		</form>
		</div>
	<?php endif; ?>
    <table class="table table-condensed" id="bloglist">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>URL</th>
        <th>Updated</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($this->blogs as $b): ?>
      <tr id="blog<?= $b['bid'] ?>">
        <td class="bid"><a target="_blank" href="<?= config('basepath'), '/blog/', $b['bid'], '" id="', $b['bid'], '">', $b['bid'] ?></a></td>
        <td class="bname"><?= $b['name'] ?></td>
        <td class="burl"><a target="_blank" href="<?= $b['url'] ?>"><?= $b['url'] ?></a></td>
        <td class="blupd"><?= date('d M Y', $b['ts']); ?></td>
        <td class="brss hidden"><?= $b['rss'] ?></td>
        <?php if($this->undelete): ?>
        <td><button class="btn btn-mini btn-info" onclick="undeleteblog(<?= $b['bid'] ?>);">Restore</button></td>
        <?php else: ?>
        <td><button class="btn btn-mini btn-primary" onclick="window.open('<?= config("basepath"), "/admin/editblog/?id=", $b['bid'] ?>', 
        '','toolbar=no,scrollbars=yes,width=500,height=500');">Edit</button>
        <button class="btn btn-mini btn-danger" onclick="deleteblog(<?= $b['bid'] ?>);">Delete</button></td>
        <?php endif; ?>
      </tr>
     <?php endforeach; ?>
      <tr><td><a id="endofpage"></a></td><td></td><td></td><td></td></tr>
    </tbody>
  </table>
  
  <?php if(count($this->blogs) == 30): ?>
  <div class="pagination pagination-centered">
    <ul>
    <li><a href="<?= config("basepath"), "/admin/modify/?page=", $this->pageno - 1 ?>">&laquo;</a></li>
    <li class="active">
    <a href="<?= config("basepath"), "/admin/modify/?page=", $this->pageno, '">', $this->pageno + 1 ?></a>
    </li>
    <li><a href="<?= config("basepath"), "/admin/modify/?page=", $this->pageno + 1, '">', $this->pageno + 2 ?></a></li>
    <li><a href="<?= config("basepath"), "/admin/modify/?page=", $this->pageno + 2, '">', $this->pageno + 3 ?></a></li>
    <li><a href="<?= config("basepath"), "/admin/modify/?page=", $this->pageno + 3, '">', $this->pageno + 4 ?></a></li>
    <li><a href="<?= config("basepath"), "/admin/modify/?page=", $this->pageno + 4 ?>">&raquo;</a></li>
    </ul>
  </div>
  <?php endif; ?>
  <?php endif; ?>
</div><!--/span-->	  

