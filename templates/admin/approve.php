
<div class="span9">
    <legend>Join Requests</legend>
    <?php if(count($this->blogs) == 0): ?>
    <div class="alert alert-info">
    No join requests!
    </div>
    <?php else: ?>
    <table class="table table-condensed">
    <thead>
      <tr>
        <th>Title</th>
        <th>URL</th>
        <th>Feed</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($this->blogs as $b): ?>
      <tr id="blog<?= $b['bid'] ?>">
        <td class="bname"><?= $b['name'] ?></td>
        <td class="burl"><a target="_blank" href="<?= $b['url'] ?>"><?= $b['url'] ?></a></td>
        <td class="brss"><a target="_blank" href="<?= $b['feed'] ?>"><?= $b['feed'] ?></a></td>
        <td><button class="btn btn-mini btn-success" onclick="undeleteblog(<?= $b['bid'] ?>);">Add</button>
        <button class="btn btn-mini btn-danger" onclick="deleteblog(<?= $b['bid'] ?>);">Delete</button></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div><!--/span-->	  

