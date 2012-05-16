<?php

/*
	kottu.class.php, the "Kottu API"

	09/05/12	This is where all the Kottu logic will reside [janith]
	
*/

class Kottu
{
	private $dbh;
	private $now;
	private $stats;

	public function __construct() {
	
		$this->dbh = new DBConn();
		$this->now = time();
		$this->stats = array();
	}


	/*
		returns all the posts that fit the criteria given
	*/
	public function fetchallposts($lang='all', $time='off', $pageno=0) {
	
		$lang = ($lang === 'all') ? '%' : $lang;
		$page = ((int) $pageno) * 20;
		
		$posts = array();
		
		if($time === 'off') {
			
			$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
				."p.serverTimestamp, p.postBuzz, b.blogName, p.thumbnail, "
				."p.postContent, p.fbCount, p.tweetCount FROM posts AS p, blogs "
				."AS b WHERE b.bid = p.blogID AND p.language LIKE :lang ORDER BY "
				."p.serverTimestamp DESC LIMIT $page, 20", array(':lang'=>$lang));
		}
		else {
		
			$day = 0;

			if($time == 'today')	{ $day = $this->now - (24 * 60 * 60); }
			elseif($time == 'week')	{ $day = $this->now - (7 * 24 * 60 * 60); }
			elseif($time == 'month'){ $day = $this->now - (30 * 24 * 60 * 60); }

			$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
				."p.serverTimestamp, p.postBuzz, b.blogName, p.thumbnail, "
				."p.postContent, p.fbCount, p.tweetCount FROM posts AS p, blogs "
				."AS b WHERE b.bid = p.blogID AND p.language LIKE :lang AND "
				."serverTimestamp > :time ORDER BY postBuzz DESC LIMIT $page, 20", 
				array(':lang'=>$lang, ':time'=>$day));

		}

		if($resultset) {
		
			while(($row = $resultset->fetch()) != false) {
			
				$p['id']	= $row[0];
				$p['title'] = strip_tags($row[1]);
				$p['link']	= $row[2];
				$p['ts']	= $this->humants($row[3]);
				$p['longt'] = date('D, d M Y H:i:s O', $row[3]);
				$p['buzz']	= $this->chilies($row[4]);
				$p['blog']	= $row[5];
				$p['img']	= strlen($row[6]) > 1 ? $row[6] : config('basepath')
								.'/img/none.png';
				$p['cont']	= $row[7];
				$p['fb']	= $row[8];
				$p['tw']	= $row[9];
				
				$posts[] 	= $p;
			}
		}
		
		return $posts;
	}
	
	/*
		returns content and everything for a given post id
	*/
	public function fetchpostbyid($id) {
	
		$p = array();
		
		$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
			."p.serverTimestamp, p.postBuzz, b.blogName, p.thumbnail, "
			."p.postContent FROM posts AS p, blogs AS b WHERE b.bid = p.blogID "
			."AND p.postID = :id", array(':id' => $id));
		
		if($resultset && ($row = $resultset->fetch()) != false) {
			
			$p['id']	= $row[0];
			$p['title'] = strip_tags($row[1]);
			$p['link']	= $row[2];
			$p['ts']	= $this->humants($row[3]);
			$p['buzz']	= $this->chilies($row[4]);
			$p['blog']	= $row[5];
			$p['img']	= $row[6];
			$p['cont']	= strip_tags($row[7]);
		}
		
		return $p;
	}
	
	/*
		basic search functionality
	*/
	public function search($str, $pageno) {
	
		$posts = array();
		$str = "%$str%";
		$page = ((int) $pageno) * 20;
		
		$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
			."p.serverTimestamp, p.postBuzz, b.blogName, p.thumbnail, "
			."p.postContent, p.fbCount, p.tweetCount FROM " 
			."posts AS p, blogs AS b WHERE b.bid = p.blogID AND "
			."(p.postContent LIKE :string OR p.title LIKE :string) ORDER BY "
			."serverTimestamp DESC LIMIT $page, 20", array(':string'=>$str));
		
		if($resultset) {
		
			while(($row = $resultset->fetch()) != false) {
			
				$p['id']	= $row[0];
				$p['title'] = strip_tags($row[1]);
				$p['link']	= $row[2];
				$p['ts']	= $this->humants($row[3]);
				$p['buzz']	= $this->chilies($row[4]);
				$p['blog']	= $row[5];
				$p['img']	= strlen($row[5]) > 0 ? $row[6] : config('basepath')
								.'/img/none.png';
				$p['cont']	= $row[7];
				$p['fb']	= $row[8];
				$p['tw']	= $row[9];
				
				$posts[] 	= $p;
			}
		}
		
		return $posts;
	}
	
	/*
		returns number of blogs listed on Kottu
	*/
	public function fetchnumblogs() {
	
		$resultset = $this->dbh->query("SELECT COUNT(*) FROM blogs", array());
		
		if($resultset && ($row = $resultset->fetch()) != false) {
			
			return $row[0];
		}
	}
	
	/*
		returns names and links to all the blogs listed on Kottu
	*/
	public function fetchallblogs() {
	
		$blogs = array();
		
		$resultset = $this->dbh->query("SELECT blogName, blogURL FROM blogs "
			."ORDER BY blogName", array());
		
		if($resultset) {
			while (($row = $resultset->fetch()) != false) {
			
				$b['name']	= $row[0];
				$b['link']	= $row[1];
				
				$blogs[] = $b;
			}
		}
		
		return $blogs;
	}
	
	/*
		fetches 20 most popular blogs. 2592000 is *in the last month*, btw.			
	*/
	public function fetchpopblogs() {
	
		$blogs = array();
		
		$resultset = $this->dbh->query("SELECT blogName, blogURL, "
			."AVG(postBuzz), MAX(serverTimestamp) FROM blogs AS b, posts AS p "
			."WHERE b.bid = p.blogID AND p.serverTimestamp > :month GROUP BY "
			."b.bid HAVING COUNT(p.postBuzz) >= 3 ORDER BY AVG(postBuzz) DESC "
			."LIMIT 20", array(':month'=>($this->now - 2592000)));
		
		if($resultset) {
			while (($row = $resultset->fetch()) != false) {
			
				$b['name']	= $row[0];
				$b['link']	= $row[1];
				$b['buzz']	= $this->chilies($row[2]);
				$b['lupdt']	= $this->humants($row[3]);

				$blogs[] = $b;
			}
		}
		
		return $blogs;
	}
	
	/*
		Gets the eVillage scroller in the sidebar
	*/
	public function sidescroller() {
	
		$posts = array();
		
		$resultset = $this->dbh->query("SELECT p.link, p.title, "
			."p.serverTimestamp, p.postContent FROM posts AS p WHERE p.blogid "
			."IN (1407, 1403, 419, 278, 1411, 1412, 1413, 1414, 1431) ORDER BY "
			."serverTimestamp DESC LIMIT 5", array());
		
		if($resultset) {
			while (($row = $resultset->fetch()) != false) {
			
				$p['link']	= $row[0];
				$p['title']	= $row[1];
				$p['ts']	= $this->humants($row[2]);
				$p['cont']	= $row[3];
				
				$posts[] = $p;
			}
		}
		
		return $posts;
	}
	
	/*
		
	*/
	public function updatebuzz($postid, $buzz, $tcount, $fcount) {
	
		$this->dbh->query("UPDATE posts SET postBuzz = :buzz, tweetCount = :tw, "
					."fbCount = :fb, api_ts = :ts WHERE postID = :id",
					array(':buzz'=>$buzz, ':tw'=>$tcount, ':fb'=>$fcount, 
					':ts'=>$this->now,':id'=>$postid));
	}
	
	/*
		Go.php click inserter
		
		If there is a click from this ip address within the last 12 hours,
		we won't register a new click. btw, 12 hrs = 43200 seconds
	*/
	function insertclick($ip, $pid)
	{
		$resultset = $this->dbh->query("SELECT MAX(timestamp) FROM clicks WHERE "
			."timestamp > :hrs AND ip = :ip AND pid = :pid", 
			array(':ip'=>$ip, ':pid'=>$postid, ':hrs'=>($this->now - 43200))); 

		if($resultset && $resultset->fetch() == false)
		{
			$resultset = $this->dbh->query("INSERT INTO clicks(ip, pid, "
				."timestamp) VALUES (:ip, :pid, :ts)", array(':ip'=>$ipadr, 
				':pid'=>$pid, ':ts'=>$this->now));
		}

		
	}
	
	/*
	$resultset = $DBConn->query("SELECT postID, link FROM posts WHERE ".
		"serverTimestamp > (unix_timestamp(now()) - 86400) ORDER BY api_ts ASC LIMIT 20", array());

	if($resultset)
	{
		// an empty array to hold the stats
		$results = array();

		// a counter, for debugging and statistics
		$counter = 0;

		//We get the maximum counts for all the metrics, for calculation purposes
		$maxarr = Stats::getMaximums($DBConn);

		//if($maxarr == false) { die("spicecalc could not get maximums and died"); }

		while($array = $resultset->fetch())
		{
			$postid = $array[0];
			$url 	= $array[1];

			$tweets = Stats::getTweetCount($url);
			$fbooks = Stats::getFBCount($url);
			$clicks = Stats::getClicks($postid, $DBConn);

			$results[$postid] = array($tweets, $fbooks, $clicks);

			// we check if any of the new tweet/fb counts are bigger than the max
			// if they are so, we have to update the "max".
			if ($maxarr['maxtweets'] < $tweets) { $maxarr['maxtweets'] = $tweets; } 
			if ($maxarr['maxfbooks'] < $fbooks) { $maxarr['maxfbooks'] = $fbooks; }

			$counter++;
		}

		$now = time();

		// now we do the calculations and write the stats back to db, post by post
		foreach($results as $key => $value)
		{
			$tweetbuzz = unskew($value[0] / ($maxarr['maxtweets'] + 1));
			$fbookbuzz = unskew($value[1] / ($maxarr['maxfbooks'] + 1));
			$clickbuzz = unskew($value[2] / ($maxarr['totalclicks'] + 1));

			// we do the calculations...
			$spice = ($tweetbuzz * $tweetweight) + ($fbbuzz * $fbookweight) + ($clickbuzz * $clickweight);

			// ...and put away our toys
			
	/*
		get total clicks (all day) and max fb likes and tweets (per post)
	*/				
	public function getmaxstats()
	{
	
		if(count($this->stats) == 0) {
			
			/* 24 * 60 * 60 seconds = 1 day */
			$day = $this->now - 86400;
			
			$rs1 = $this->dbh->query("SELECT COUNT(*) FROM clicks WHERE "
				."timestamp > :day", array(':day'=>$day));
			$rs2 = $this->dbh->query("SELECT MAX(tweetCount), MAX(fbCount) FROM "
				."posts WHERE serverTimestamp > :day", array(':day'=>$day));

			if($rs1 && $rs2)
			{
				$arr1 = $rs1->fetch();
				$arr2 = $rs2->fetch();

				$this->stats['totalclicks']	= $arr1[0];
				$this->stats['maxtweets']	= $arr2[0];
				$this->stats['maxfbooks']	= $arr2[1];
			}
		}

		return $this->stats;
	}

	/*
		make sure values are always between 0 and 1
	*/
	public function unskew($x) {
	
		return ($x > 1) ? 1 : (($x < 0) ? 0 : $x);
	} 
	
	/*
		returns human readable timestamp 
	*/
	public function humants($timestamp) {
	
		$now = $this->now;

		if(($now - $timestamp) <= 60) {
			$timestamp = 'less than a minute ago';
		}
		else if(($now - $timestamp) < (60 * 60)) {
			$timestamp = (int) (($now - $timestamp) / 60);
			if($timestamp == 1) { $timestamp .= ' minute ago'; }
			else { $timestamp .= ' minutes ago'; }
		}
		else if(($now - $timestamp) < (24 * 60 * 60)) {
			$timestamp = (int) (($now - $timestamp) / (60 * 60));
			if($timestamp == 1) { $timestamp .= ' hour ago'; }
			else { $timestamp .= ' hours ago'; }
		}
		else if(($now - $timestamp) < (48 * 60 * 60)) {
			$timestamp = 'yesterday';
		}
		else {
			$timestamp = date('j F Y', $timestamp);
		}
		
		return $timestamp;
	}
	
	/*
		returns chilies for each post based on buzz
	*/
	public function chilies($buzz) {
	
		$buzz = (int)($buzz * 100);
		$out = '';

		if($buzz <= 1)		{ $out = 'chili1.png'; }
		elseif($buzz <= 15)	{ $out = 'chili2.png'; }
		elseif($buzz <= 35)	{ $out = 'chili3.png'; }
		elseif($buzz <= 55)	{ $out = 'chili4.png'; }
		else				{ $out = 'chili5.png'; }
	
		return $out;
	}
}

?>
