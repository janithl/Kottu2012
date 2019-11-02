<?php

/*
	kottu.class.php, the "Kottu API"

	09/05/12	This is where all the Kottu logic will reside [janith]
	
	09/06/12	Added tags [janith]
*/

class Kottu
{
	private $dbh;
	private $now;

	public function __construct() {
	
		$this->dbh = DB::connect();
		$this->now = time();
	}


	/*
		returns all the posts that fit the criteria given
	*/
	public function fetchallposts($lang='all', $time='off', $pageno=0, $chunk=20) {
	
		$lang = ($lang === 'all') ? '%' : $lang;
		$page = ((int) $pageno) * $chunk;
		
		$posts = array();
		
		if($time === 'off') {
			$resultset = $this->dbh->query("SELECT p.postID, p.title, "
				."p.link, p.serverTimestamp, p.postBuzz, b.blogName, b.bid, "
				."p.thumbnail, p.postContent, p.fbCount, p.tweetCount, p.trend "
				."FROM posts AS p, blogs AS b WHERE b.active = 1 AND b.bid = "
				."p.blogID AND p.language LIKE :lang ORDER BY "
				."p.serverTimestamp DESC LIMIT :page, :chunk", 
				array(':lang' => $lang, ':page' => $page, ':chunk' => $chunk));
		}
		else {
			$day = 0;

			if($time == 'today' || $time === 'trending') { 
				$day = $this->now - (24 * 60 * 60); 
			}
			elseif($time == 'week')	{ 
				$day = $this->now - (7 * 24 * 60 * 60); 
			}
			elseif($time == 'month') { 
				$day = $this->now - (30 * 24 * 60 * 60); 
			}

			$order = ($time === 'trending') ? 'trend' : 'postBuzz';

			$resultset = $this->dbh->query("SELECT p.postID, p.title, "
				."p.link, p.serverTimestamp, p.postBuzz, b.blogName, b.bid, "
				."p.thumbnail, p.postContent, p.fbCount, p.tweetCount, p.trend "
				."FROM posts AS p, blogs AS b WHERE b.active = 1 AND b.bid = "
				."p.blogID AND p.language LIKE :lang AND serverTimestamp > "
				.":time ORDER BY $order DESC LIMIT :page, :chunk", 
				array(':lang' => $lang, ':time' => $day, ':page' => $page, 
				':chunk' => $chunk));
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
				$p['bid']	= $row[6];
				$p['img']	= strlen($row[7]) > 1 ? $row[7] : config('basepath')
								.'/img/none.png';
				$p['img']	= preg_replace('/&*(w=|h=)[0-9]+/', '', $p['img']); 
				$p['cont']	= strip_tags($row[8]);
				$p['fb']	= $row[9];
				$p['tw']	= $row[10];
				$p['trend']	= $row[11];
				
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
			$p['img']	= preg_replace('/&*(w=|h=)[0-9]+/', '', $p['img']);
			$p['cont']	= strip_tags($row[7]);
		}
		
		return $p;
	}
	
	/*
		basic search functionality
	*/
	public function search($str, $pageno=0, $lang='all', $tags=false) {
	
		$posts = array();
		$str = "%$str%";
		$page = ((int) $pageno) * 20;
		$lang = ($lang === 'all') ? '%' : $lang;
		
		if($tags) {
		
			/* array of possible related tags */
			$tagarray = array( 
'tech' 		=> array('tech','science','linux','windows','virus',',mobile',
				'software','phones','android','electronic','physics',
				'mathematics','maths','web,','sharepoint','internet'),
'travel'	=> array('travel','food','recipes','hotel','hike','hiking','beach'),
'nature'	=> array('nature','environment','conservation','animal','wildlife',
				'pollution','forest'),
'sports'	=> array('(,|\b)sport,','(,|\b)sports,','cricket','rugby',
				'football','soccer','volleyball','athlet','tennis'),
'news'		=> array('news','breaking','security','election','media',',press'),
'personal'	=> array('personal','life,','love','family','romance','exam',
				'emotion','thought','story','stories','social','friend',
				'boredom','rant','ramblings','work'),
'entertainment'	=> array('entertainment','art,','music','song','album','movie',
				'film','cinema',' tv ','video','literature','literary',
				'magazine','event'),
'poetry'	=> array('poetry','poem','poetry'),
'business'	=> array('business','industry','bank','economy','economics',
				'development','agricultur'),
'politics'	=> array('politics','election','peace','war,','conflict','security',
				'economy','development','youth','tigers','community'),
'photo'		=> array('photo','image'),
'faith'		=> array('faith','religion','belief','buddhis','christian','hindu',
				'islam','muslim','god,','atheis'),
'education'	=> array('education','exam','university','uni,','school','teach'),
'other'		=> array('other','uncategorized','random','general'));

			/* sanitize */
			$tags = preg_replace("/[^a-z]/", "", $tags);
	
			if(is_array($tagarray[$tags])) {
			
				$tagtext = '.*(' . implode('|',$tagarray[$tags]) . ').*';
				
				$resultset = $this->dbh->query("SELECT p.postID, p.title, "
				."p.link, p.serverTimestamp, p.postBuzz, b.blogName, b.bid, "
				."p.thumbnail, p.postContent, p.fbCount, p.tweetCount "
				."FROM posts AS p, blogs AS b WHERE b.active = 1 AND b.bid = "
				."p.blogID AND language LIKE :lang AND tags RLIKE :tags "
				."ORDER BY serverTimestamp DESC LIMIT :limit, 20", array(
				':lang' => $lang, ':tags' => $tagtext, ':limit' => $page));
			}
			else {
			
				$resultset = false;
			}
		}
		else {
		
			$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
			."p.serverTimestamp, p.postBuzz, b.blogName, b.bid, p.thumbnail, "
			."p.postContent, p.fbCount, p.tweetCount FROM posts AS p, "
			."blogs AS b WHERE b.active = 1 AND b.bid = p.blogID AND language "
			."LIKE :lang AND (p.postContent LIKE :str1 OR p.title LIKE "
			.":str2 OR b.blogName LIKE :str3) ORDER BY serverTimestamp "
			."DESC LIMIT :limit, 20", array(':lang' => $lang, ':str1' => $str,
			':str2' => $str, ':str3' => $str, ':limit' => $page));
		}
		
		if($resultset) {
		
			while(($row = $resultset->fetch()) != false) {
			
				$p['id']	= $row[0];
				$p['title'] = strip_tags($row[1]);
				$p['link']	= $row[2];
				$p['ts']	= $this->humants($row[3]);
				$p['buzz']	= $this->chilies($row[4]);
				$p['blog']	= $row[5];
				$p['bid']	= $row[6];
				$p['img']	= strlen($row[7]) > 1 ? $row[7] : config('basepath')
								.'/img/none.png';
				$p['img']	= preg_replace('/&*(w=|h=)[0-9]+/', '', $p['img']);
				$p['cont']	= $row[8];
				$p['fb']	= $row[9];
				$p['tw']	= $row[10];
				
				$posts[] 	= $p;
			}
		}
		
		return $posts;
	}
	
	/*
		returns number of blogs listed on Kottu
	*/
	public function fetchnumblogs() {
	
		$resultset = $this->dbh->query("SELECT COUNT(*) FROM blogs WHERE "
		."active = 1");
		
		if($resultset && ($row = $resultset->fetch()) != false) {
			
			return $row[0];
		}
	}
	
	/*
		returns names and links to all the blogs listed on Kottu
	*/
	public function fetchallblogs() {
	
		$blogs = array();
		
		$resultset = $this->dbh->query("SELECT bid, blogName FROM blogs "
		."WHERE active = 1 ORDER BY blogName");
		
		if($resultset) {
			while (($row = $resultset->fetch()) != false) {
			
				$b['bid']	= $row[0];
				$b['name']	= $row[1];
				
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
		
		$resultset = $this->dbh->query("SELECT bid, blogName, AVG(postBuzz), "
		."MAX(serverTimestamp) FROM blogs AS b, posts AS p WHERE b.active = 1 "
		."AND b.bid = p.blogID AND p.serverTimestamp > :month GROUP BY b.bid "
		."HAVING COUNT(p.postBuzz) >= 3 ORDER BY AVG(postBuzz) DESC LIMIT 20", 
		array(':month'=>($this->now - 2592000)));
		
		if($resultset) {
			while (($row = $resultset->fetch()) != false) {
			
				$b['bid']	= $row[0];
				$b['name']	= $row[1];
				$b['buzz']	= $this->chilies($row[2]);
				$b['lupdt']	= $this->humants($row[3]);

				$blogs[] = $b;
			}
		}
		
		return $blogs;
	}
	
	/*
		Get trending topics (last 24 hours)
	*/
	public function trendingtopics() {
		$topics = array();
		
		$resultset = $this->dbh->query("SELECT tid, term, doc_freq FROM terms "
		."WHERE stopword = 0 ORDER BY tf_idf DESC LIMIT 10", array());
		
		if($resultset) {
			while (($row = $resultset->fetch()) != false) {
				$topics[] 	= array(
					'tid' 	=> $row[0],
					'term' 	=> $row[1],
					'docs' 	=> $row[2]
				);
			}
		}
		
		return $topics;
	}
	
	/*
		Get topic title
	*/
	public function fetchtopictitle($tid) {
		$resultset = $this->dbh->query("SELECT term FROM terms "
		."WHERE tid = :tid", array(':tid' => $tid));
		
		if($resultset && ($row = $resultset->fetch()) != false) {
			return $row[0];
		}
		
		return false;
	}
	
	/*
		Get posts for topic
	*/
	public function fetchtopicposts($tid, $pageno=0) {
		$posts 	= array();
		$page 	= ((int) $pageno) * 20;
		
		$resultset = $this->dbh->query("SELECT p.postID, p.title, "
			."p.link, p.serverTimestamp, p.postBuzz, b.blogName, b.bid, "
			."p.thumbnail, p.postContent, p.fbCount, p.tweetCount "
			."FROM posts AS p, blogs AS b WHERE b.active = 1 "
			."AND b.bid = p.blogID AND p.postID IN "
			."(SELECT pid FROM post_terms WHERE tid = :tid) "
			."ORDER BY p.serverTimestamp DESC LIMIT :page, 20", 
			array(':tid' => $tid, ':page' => $page));

		if($resultset) {
			while(($row = $resultset->fetch()) != false) {
				$p['id']	= $row[0];
				$p['title'] = strip_tags($row[1]);
				$p['link']	= $row[2];
				$p['ts']	= $this->humants($row[3]);
				$p['longt'] = date('D, d M Y H:i:s O', $row[3]);
				$p['buzz']	= $this->chilies($row[4]);
				$p['blog']	= $row[5];
				$p['bid']	= $row[6];
				$p['img']	= strlen($row[7]) > 1 ? $row[7] : config('basepath')
								.'/img/none.png';
				$p['img']	= preg_replace('/&*(w=|h=)[0-9]+/', '', $p['img']); 
				$p['cont']	= strip_tags($row[8]);
				$p['fb']	= $row[9];
				$p['tw']	= $row[10];
				
				$posts[] 	= $p;
			}
		}
		
		return $posts;
	}
	
	/*
		Go.php click inserter
		
		If there is a click from this ip address within the last 12 hours,
		we won't register a new click. btw, 12 hrs = 43200 seconds
	*/
	public function insertclick($ip, $pid)
	{
		$this->dbh->query("INSERT INTO clicks(pid, ip, timestamp, hourstamp) "
			."VALUES(:pid, :ip, :ts, :hs)", array(':pid' => $pid, ':ip' => $ip, 
			':ts' => $this->now, ':hs' => (int)($this->now / 3600)));
	}

	/*
		Get post URL
	*/
	public function fetchurl($id) {
		$resultset = $this->dbh->query("SELECT link FROM posts "
		."WHERE postId = :id", array(':id' => $id));
		
		if($resultset && ($row = $resultset->fetch()) != false) {
			return $row[0];
		}
		
		return false;
	}
	
	/*
		returns all the posts for a particular blogID
	*/
	public function fetchblogposts($blogid, $pageno = 0, $pop = false) {
	
		$posts	= array();
		$page	= ((int) $pageno) * 20;
		$order	= $pop ? 'serverTimestamp' : 'postBuzz';
		
		$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
		."p.serverTimestamp, p.postBuzz, b.blogName, b.bid, p.thumbnail, "
		."p.postContent, p.fbCount, p.tweetCount FROM posts AS p, blogs AS b "
		."WHERE b.active = 1 AND b.bid = p.blogID AND p.blogID = :blogid "
		."ORDER BY ".$order." DESC LIMIT :limit, 20", 
		array(':blogid' => $blogid, ':limit' => $page));
		
		if($resultset) {
		
			while(($row = $resultset->fetch()) != false) {
			
				$p['id']	= $row[0];
				$p['title'] = strip_tags($row[1]);
				$p['link']	= $row[2];
				$p['ts']	= $this->humants($row[3]);
				$p['buzz']	= $this->chilies($row[4]);
				$p['blog']	= $row[5];
				$p['bid']	= $row[6];
				$p['img']	= strlen($row[7]) > 1 ? $row[7] : config('basepath')
								.'/img/none.png';
				$p['img']	= preg_replace('/&*(w=|h=)[0-9]+/', '', $p['img']);
				$p['cont']	= $row[8];
				$p['fb']	= $row[9];
				$p['tw']	= $row[10];
				
				$posts[] 	= $p;
			}
		}
		
		return $posts;
	}
	
	/*
		returns blog details for a blogID
	*/
	public function blogdetails($blogid) {
	
		$blog	= array();
		
		$resultset = $this->dbh->query("SELECT blogName, blogURL, "
		."COUNT(postID), AVG(postBuzz), MAX(serverTimestamp) "
		."FROM blogs AS b JOIN posts AS p ON (b.bid = p.blogID) "
		."WHERE b.active = 1 AND b.bid = :id GROUP BY b.bid",
		array(':id'=>$blogid));
		
		if($resultset && (($row = $resultset->fetch()) != false)) {
			
			$blog['name']	= $row[0];
			$blog['url']	= $row[1];
			$blog['count']	= $row[2];
			$blog['buzz']	= $this->chilies($row[3]);
			$blog['ts']	= $this->humants($row[4]);
		}
		
		return $blog;
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

		if($buzz <= 1)		{ $out = 1; }
		elseif($buzz <= 15)	{ $out = 2; }
		elseif($buzz <= 35)	{ $out = 3; }
		elseif($buzz <= 55)	{ $out = 4; }
		else				{ $out = 5; }
	
		return $out;
	}
}

?>
