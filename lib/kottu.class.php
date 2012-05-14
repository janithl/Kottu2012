<?php

/*
	kottu.class.php, the "Kottu API"

	09/05/12	This is where all the Kottu logic will reside [janith]
	
*/

class Kottu
{
	private $dbh;
	private $now;

	public function __construct() {
	
		$this->dbh = new DBConn();
		$this->now = time();
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
				."p.postContent FROM posts AS p, blogs AS b WHERE "
				."b.bid = p.blogID AND p.language LIKE :lang ORDER BY "
				."p.serverTimestamp DESC LIMIT $page, 20 ", array(':lang'=>$lang));
		}
		else {
		
			$day = 0;

			if($time == 'today')	{ $day = $this->now - (24 * 60 * 60); }
			elseif($time == 'week')	{ $day = $this->now - (7 * 24 * 60 * 60); }
			elseif($time == 'month'){ $day = $this->now - (30 * 24 * 60 * 60); }

			$resultset = $this->dbh->query("SELECT p.postID, p.title, p.link, "
				."p.serverTimestamp, p.postBuzz, b.blogName, p.thumbnail, "
				."p.postContent FROM posts AS p, blogs AS b WHERE "
				."b.bid = p.blogID AND p.language LIKE :lang AND "
				."serverTimestamp > :time ORDER BY postBuzz DESC "
				."LIMIT $page, 20", array(':lang'=>$lang, ':time'=>$day));

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
				$p['img']	= strlen($row[6]) > 1 ? $row[6] : '../images/none.png';
				$p['cont']	= $row[7];
				
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
		
		$resultset = $this->dbh->query("SELECT p.postID, p.title, "
				."p.serverTimestamp, p.postBuzz, b.blogName, p.thumbnail FROM " 
				."posts AS p, blogs AS b WHERE b.bid = p.blogID AND "
				."(p.postContent LIKE :string OR p.title LIKE :string) ORDER BY "
				."serverTimestamp DESC LIMIT $page, 20", array(':string'=>$str));
		
		if($resultset) {
		
			while(($row = $resultset->fetch()) != false) {
			
				$p['id']	= $row[0];
				$p['title'] = strip_tags($row[1]);
				$p['ts']	= $this->humants($row[2]);
				$p['buzz']	= $this->chilies($row[3]);
				$p['blog']	= $row[4];
				$p['img']	= strlen($row[5]) > 0 ? $row[5] : '../images/none.png';
				
				$posts[] 	= $p;
			}
		}
		
		return $posts;
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
