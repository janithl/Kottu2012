<?php 
	header('Content-type: application/rss+xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:media="http://search.yahoo.com/mrss/"
	>

<channel>
	<title><?php echo $this->title; ?></title>
	<atom:link href="<?php echo config('basepath'), $_SERVER['REQUEST_URI']; ?>" rel="self" type="application/rss+xml" />
	<link><?php echo config('basepath'); ?></link>
	<description>Kottu is a Sri Lankan blog aggregator</description>
	<lastBuildDate><?php echo $this->date; ?></lastBuildDate>
	<language><?php echo $this->lang; ?></language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>Kottu FeedGen.php</generator>
	
<?php foreach($this->posts as $i): ?>
	<item>
	<title><?php echo $i['title']; ?></title>
	<link><?php echo $i['link']; ?></link>
	<guid><?php echo $i['link']; ?></guid>
	<comments><?php echo $i['link']; ?>#comments</comments>
	<pubDate><?php echo $i['longt']; ?></pubDate>
	<dc:creator><![CDATA[<?php echo strip_tags($i['blog']); ?>]]></dc:creator>
	<description><![CDATA[<?php echo strip_tags(str_replace("\n", " ", $i['cont'])); ?>]]></description>
<?php if($i['img'] !== config('basepath').'/img/none.png'): ?>
	<media:content url="<?php echo $i['img']; ?>" medium="image"><media:title type="html">Thumbnail</media:title></media:content>
<?php endif; ?>
	</item>

<?php endforeach ?>
	
</channel>
</rss>
