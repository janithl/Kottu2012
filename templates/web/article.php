<article class="panel panel-default">
    <div class="panel-body">
        <h3><a  target="_blank" href="<?php echo config('basepath') . '/go/?id=' . $i['id'] . '&url=' . $i['link']; ?>" 
        id="<?php echo $i['id']; ?>"><?php echo $i['title']; ?></a></h3>
        <a href="<?php echo config('basepath') . '/blog/' . $i['bid']; ?>"><?php echo $i['blog']; ?></a>
    
        <div class="media">
<?php if($i['img'] != config('basepath') .'/img/none.png'): ?>
            <div class="media-left media-top hidden-xs">
                <img class="media-object" alt="<?php echo $i['title']; ?>" src="<?php echo config('basepath') . '/img/?q=85&src=' . $i['img']; ?>"/></span>
            </div>
<?php endif; ?>
            
            <div class="media-body"><?= strip_tags(str_replace("\n", " ", $i['cont'])); ?></div>
        </div>
    </div>
    
    <div class="panel-footer">
        <button class="btn btn-link btn-ts"><?php echo $i['ts']; ?></button>
        <button class="btn btn-primary btn-facebook" onClick="window.open('http://www.facebook.com/share.php?u=<?php echo $i['link']; ?>', 
        'Share on Facebook', 'toolbar=no, scrollbars=yes, width=500, height=400');" 
        title="This post was liked/shared <?php echo $i['fb']; ?> time(s)">
            <span class="glyphicon glyphicon-share-alt"></span> Shares: <?php echo $i['fb']; ?>
        </button>
        <button class="btn btn-link pull-right" title="The post popularity is <?php echo $i['buzz']; ?> chilies">           
            <img src="<?php echo config('basepath') , '/img/icons/chili' , $i['buzz']; ?>.png" 
                alt="<?php echo $i['buzz']; ?> chilies"/>
        </button>
    </ul>
    </div>
</article>