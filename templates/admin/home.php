
<div class="span9">
    <div class="hero-unit">
    <p>
    <h3>Welcome to the Kottu admin panel</h3><br>
    <a class="btn btn-primary btn-large" onclick="window.open('<?= config('basepath') ?>/admin/addblog', '','toolbar=no,scrollbars=yes,width=500,height=500');" href="#">
    Add a blog</a>
    <a href="<?= config('basepath') ?>/admin/stats"class="btn btn-primary btn-large">
    View stats &raquo;</a> 
    <?php if($this->joins > 0): ?>
    <a href="<?= config('basepath') ?>/admin/approve"class="btn btn-info btn-large">
    Approve join requests (<?= $this->joins; ?>) &raquo;</a> 
    <?php endif; ?>
    </p>
    </div>
    
    <legend>Recently added blogs</legend>
    <table class="table table-condensed" id="bloglist">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>URL</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($this->rblogs as $b): ?>
      <tr id="blog<?= $b['bid'] ?>">
        <td class="bid"><a target="_blank" href="<?= config('basepath'), '/blog/', $b['bid'], '" id="', $b['bid'], '">', $b['bid'] ?></a></td>
        <td class="bname"><?= $b['name'] ?></td>
        <td class="burl"><a target="_blank" href="<?= $b['url'] ?>"><?= $b['url'] ?></a></td>
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
    
    <legend>User login history</legend>
    <table class="table table-striped">
    <thead><tr>
    <th>User</th>
    <th>IP Address</th>
    <th>Timestamp</th>
    <th>User Agent</th>
    </tr></thead>
    <tbody>
    <?php foreach($this->logins as $l): ?>
    <tr>
    <td><?= $l['user']; ?></td>
    <td><?= $l['ip']; ?></td>
    <td><span class="label label-inverse" title="<?= date('d M Y, H:i:s A', $l['ts']); ?>">
    <?= ((int)((time() - $l['ts'])/60) > 120) ? (int)((time() - $l['ts'])/3600) . ' hours' : (int)((time() - $l['ts'])/60) . ' minutes' ?> ago</span></td>
    <td><span class="label label-info" title="<?= $l['uagent']; ?>">
    <?php $ua = explode(' ', $l['uagent']); echo end($ua); ?>
    </span></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
</div><!--/span-->	

