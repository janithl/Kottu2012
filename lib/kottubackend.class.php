<?php

/*
	kottubackend.class.php, contains the backend of Kottu - feedget/spiceget

	08/06/12	Started this [janith]
	
*/

class KottuBackend
{
	private $dbh;
	private $now;
	private $stats;
	private $fbapp;

	public function __construct() {
	
		$this->dbh = DB::connect();
		$this->now = time();
		$this->stats = array();
	}
	
	/* 
		clear the kottu cache
	*/
	public function cacheclear() {
	
		foreach (glob("./webcache/*.html") as $f) {
			unlink($f);
			echo "deleted file $f\n";
		}
	}
	
	/*
		Update post spice	
	*/
	public function updatestats($postid, $spice, $tcount, $fcount) {
	
		$this->dbh->query("UPDATE posts SET postBuzz = :buzz, tweetCount = :tw, "
					."fbCount = :fb, api_ts = :ts WHERE postID = :id",
					array(':buzz'=>$spice, ':tw'=>$tcount, ':fb'=>$fcount, 
					':ts'=>$this->now,':id'=>$postid));
	}
	
	/*
		Getting count of twitter shares:
		
		pretty straightforward, we send the url to the Twitter API, which 
		replies in json, which we decode.

		UPDATE: As of November 2015, Twitter has deprecated this API,
		and we're getting rid of Twitter share counts as a result. 

		https://blog.twitter.com/2015/hard-decisions-for-a-sustainable-platform
	*/
	public function gettweetcount($url) {
		$tweetcount = 0;
		/*
		$json = @file_get_contents("http://urls.api.twitter.com/1/urls/"
		."count.json?url=$url");
		
		if($json) {
		
			$twitter = json_decode($json, true);
			$tweetcount = $twitter['count'];
		}
		*/
		return $tweetcount;
	}
	
	/*
		Getting Facebook like/share count: Use FQL to get the fb count
	*/
	public function getfbcount($url) {
		$fcount = 0;

		$urlstr	= "https://graph.facebook.com/v2.7/?id=" . urlencode($url) . 
			"&access_token=" . config('fbappid') . "|" .  config('fbappkey');
		
		$json 	= @file_get_contents($urlstr);
		if($json) {
			$fb 	= json_decode($json, true);
			$fcount = $fb['share']['share_count'];
		}

		return $fcount;
	}

	/*
		getting click count for a given post id
	*/
	public function getclicks($pid) {
	
		$clicks = 0;

		$res = $this->dbh->query("SELECT COUNT(ip) FROM clicks WHERE pid= :pid", 
									array(':pid'=>$pid));

		if($res && ($row = $res->fetch()) != false) {
			$clicks = $row[0];
		}

		return $clicks;
	}
			
	/*
		get total clicks (all day) and max fb likes and tweets (per post)
	*/				
	public function getmaxstats() {
	
		if(count($this->stats) == 0) {
			
			/* 24 * 60 * 60 seconds = 1 day */
			$day = $this->now - 86400;
			
			$rs1 = $this->dbh->query("SELECT COUNT(*) FROM clicks WHERE "
				."timestamp > :day", array(':day' => $day));
			$rs2 = $this->dbh->query("SELECT MAX(tweetCount), MAX(fbCount) FROM "
				."posts WHERE serverTimestamp > :day", array(':day' => $day));

			if($rs1 && $rs2)
			{
				$arr1 = $rs1->fetch();
				$arr2 = $rs2->fetch();

				$this->stats['totclicks']	= $arr1[0];
				$this->stats['maxtweets']	= $arr2[0];
				$this->stats['maxfbooks']	= $arr2[1];
			}
		}
	}

	/*
		make sure values are always between 0 and 1
	*/
	public function unskew($x) {
	
		return ($x > 1) ? 1 : (($x < 0) ? 0 : $x);
	} 
	
	/*
		calculate spice function
	*/
	public function calculatespice() {
	
		/*	24 * 60 * 60 seconds = 1 day */
		$day = $this->now - 86400;
		
		/*	Get the maximum stats into the array */
		$this->getmaxstats();
		
		/*	An array to hold the stats for each post */
		$poststats = array();
	
		/*
			Get 30 of the most recent posts. We order by api timestamp because
			we update that when we mess with the post, ensuring a queue which 
			continously feeds us the least recently polled posts
		*/
		$this->dbh->begin();
					
		$resultset = $this->dbh->query("(SELECT postID, link FROM posts AS p, "
		."blogs AS b WHERE b.bid = p.blogid AND b.active = 1 AND "
		."serverTimestamp > :day ORDER BY api_ts LIMIT 15) UNION "
		."(SELECT postID, link FROM posts AS p, blogs AS b WHERE "
		."b.bid = p.blogid AND b.active = 1 AND api_ts = 0 LIMIT 3)", 
		array(':day' => $day));
		
		if($resultset) {
		
			while(($row = $resultset->fetch()) != false) {
			
				$postid = $row[0];
				$url 	= $row[1];

				$tw = $this->gettweetcount($url);
				$fb = $this->getfbcount($url);
				$cl = $this->getclicks($postid);
				
				/*
					If any of the new tweet/fb counts are bigger than the max,
					we have to update the "max"
				*/
				if($this->stats['maxtweets'] < $tw) {
					$this->stats['maxtweets'] = $tw;
				}
				
				if($this->stats['maxfbooks'] < $fb) {
					$this->stats['maxfbooks'] = $fb;
				}
				
				$poststats[$postid] = array($tw, $fb, $cl);
			}
			
			/*
				now we do the calculations post by post and write the stats
				back into the database
			*/
			
			foreach($poststats as $id => $stats) {
			
				$twbuzz = $this->unskew($stats[0] / ($this->stats['maxtweets'] + 1));
				$fbbuzz = $this->unskew($stats[1] / ($this->stats['maxfbooks'] + 1));
				$clbuzz = $this->unskew($stats[2] / ($this->stats['totclicks'] + 1));
				
				/* final spice calculation */
				$spice = ($twbuzz * config('twweight')) + ($fbbuzz * 
						config('fbweight')) + ($clbuzz * config('clweight'));
					
				/* update stats */	
				$this->updatestats($id, $spice, $stats[0], $stats[1]);
				printf("Spice for post %d: %5.3f (%3d t, %3d f)\n", $id, 
					$spice, $stats[0], $stats[1]);
			}
			
			$this->dbh->commit();
		}

		/** 
			update trend for posts from last 24 hours 
			from HN algorithm: https://news.ycombinator.com/item?id=1781013
		*/
		$this->dbh->query("UPDATE posts  "
		."INNER JOIN (SELECT pid, COUNT(ip) AS clicks FROM clicks GROUP BY pid) c "
		."ON (posts.postID = c.pid) "
		."SET trend = (c.clicks - 1) / POWER((UNIX_TIMESTAMP() - serverTimestamp) / 3600, :gravity)"
		."WHERE serverTimestamp > :day", array(':gravity' => 1.2, ':day' => $day));
	}
	
	/*
		Check if a post isn't in database
	*/
	public function postnotindb($url) {
	
		$res = $this->dbh->query("SELECT * FROM posts WHERE link LIKE :url", 
						array(':url' => $url));
		
		return (!$res || $res->fetch() == false);
	}
	
	/*
		generate the thumbnail
	*/
	public function generatethumbnail($postcontent) {
	
		/*	finding images in the post content	*/
		$html		= str_get_html($postcontent);
		$imglink	= null;

		if(is_object($html)) {
			foreach($html->find('img') as $element) {
				if(preg_match('/(\.jpg|\.png)/i', $element)) {
				
					$imglink = $element->src;
					break;
				}
			}
		}

		return $imglink;
	}
	
	/*
		Add post to database
	*/
	public function addnewpost($post) {
		
		/* if a post doesn't have a title, give it one */
		if(strlen($post['title']) < 1) { $post['title'] = "Untitled Post"; }

		/* generate post thumbnail */
		$post['thumb'] = $this->generatethumbnail($post['cont']);

		/* strip all the html tags from the post content */
		$post['cont'] = strip_tags($post['cont']);

		/* removing those stupid multiple spaces */
		$post['cont'] = preg_replace("/(&nbsp;|\s)+/", ' ', $post['cont']);

		/* summary generator */
		if(strlen($post['cont']) > 400) {
		
			$paragraph		= explode(' ', $post['cont']);
			$paragraph		= array_slice($paragraph, 0, 60);
			$post['cont']	= implode(' ', $paragraph);
			$post['cont']	.= " ...";
		}

		/* language filter using unicode ranges */
		$post['lang']		= 'en';
		if(preg_match('/[\x{0D80}-\x{0DFF}]{3,5}/u', $post['cont'].$post['title'])) {
			$post['lang']	= 'si';
		}
		else if(preg_match('/[\x{0B80}-\x{0BFF}]{3,5}/u', $post['cont'].$post['title'])) {
			$post['lang']	= 'ta';
		}
		else if(preg_match('/[\x{0780}-\x{07BF}]{3,5}/u', $post['cont'].$post['title'])) {
			$post['lang']	= 'dv';
		}

		/* insert the post into database */
		$this->dbh->query("INSERT INTO posts(postID, blogID, link, title, "
			."postContent, serverTimestamp, thumbnail, language, tags) VALUES "
			."(NULL, :bid, :link, :title, :content, :ts, :thumb, :lang, :tags)",
			array(	':bid'		=> $post['bid'],
					':link'		=> $post['link'],
					':title'	=> $post['title'],
					':content'	=> $post['cont'],
					':ts'		=> $post['ts'],
					':thumb'	=> $post['thumb'],
					':lang'		=> $post['lang'],
					':tags'		=> $post['tags']));
	
	}
	
	/*
		Feedget - poll feeds and add new posts
	*/
	public function feedget() {
	
		/* import simplepie, dom library and hide the errors that it throws */
		error_reporting(E_ERROR);
		require('./lib/SimplePie/simplepie.inc');
		require('./lib/simple_html_dom.php');
		
		$postadded = false;
		
		/*
			we get 50 blogs - 30 that have updated in the last two weeks and 
		 	20 that have not - sorted on least recently accessed
		 */
		$resultset = $this->dbh->query("(SELECT bid, blogRSS FROM blogs AS b, "
						."posts as p WHERE b.active = 1 AND p.blogid = b.bid "
						."GROUP BY blogid HAVING MAX(serverTimestamp) > :twk1 "
						."ORDER BY access_ts ASC LIMIT 20) UNION (SELECT bid, "
						."blogRSS FROM blogs AS b, posts as p WHERE "
						."p.blogid = b.bid GROUP BY blogid HAVING "
						."MAX(serverTimestamp) <= :twk2 ORDER BY access_ts ASC "
						."LIMIT 30) UNION (SELECT bid, blogRSS FROM blogs "
						."WHERE active = 1 ORDER BY access_ts ASC LIMIT 1)", 
						array(':twk1' => $this->now - 2419200,
						':twk2' => $this->now - 2419200));

		if($resultset)	{
		
			$this->dbh->begin();
			$items = 0;

			while(($row = $resultset->fetch()) != false) {	
			
				$items++;
				$blogid = $row[0];

				/* update blog access timestamp */
				$this->dbh->query("UPDATE blogs SET access_ts = :time WHERE "
					."bid = :bid", array(':time'=>$this->now,':bid'=>$blogid));

				/* thank god for simplepie */
				$feed = new SimplePie();
				$feed->set_feed_url($row[1]);
				$feed->init();
				$feed->handle_content_type();

				foreach($feed->get_items() as $item) {
				
					/* get post url and check if already in database */
					$link = $item->get_permalink();
					
					if($this->postnotindb($link)) {
					
						/* if not, get all the post info */
						$post = array();
						$post['link']	= $link;
						$post['bid']	= $blogid;
						$post['title']	= $item->get_title();
						$post['cont']	= $item->get_content();
						
						/*
							get post timestamp. if post is future-dated (messes 
							up kottu), give it current server timestamp
						*/
						$post['ts']	= strtotime($item->get_date());
						if($post['ts'] > $this->now) { $post['ts'] = $this->now; }
						

						/* add up to 3 tags */
						$tagcount = 0;
						foreach ($item->get_categories() as $category) {
							if($tagcount < 3) {
								$post['tags'] .= trim($category->get_label()) . ',';
								$tagcount++;
							}
						}
						
						/* add new post to array of new posts */
						$this->addnewpost($post);
						echo "Added new post: {$post['title']} ({$post['link']})\n";
						$postadded = true;

						/* and delete the object */
						unset($post);
					}
				}

				/* commit transaction to avoid losing data if we crash */
				if($items >= 120) {
					
					$this->dbh->commit();
					$this->dbh->begin();
					$items = 0;
				}
				
				$feed->__destruct();
				unset($feed);
			}
			
			$this->dbh->commit();
			
			/* clear the cache if new posts are added */
			if($postadded) {
			
				$pages = array("_", "_all_off", "_ta_off", "_si_off", "_en_off"); 
					
				foreach ($pages as $f) {
					unlink("./webcache/$f.html");
					echo "deleted file $f.html\n";
				}
			}
		}
	}
	
	/*
		Add a term to DB, ignore if already there 
		Link up the term to posts that contain it
	*/
	public function insertterms($postid, $terms) {
		
		/** store terms in db */
		$termkeys = array_keys($terms);
		$this->dbh->begin();
		$this->dbh->query("ALTER TABLE terms AUTO_INCREMENT = 100000;", array());
		foreach($termkeys as $t) {
			$this->dbh->query("INSERT IGNORE terms(term) VALUES(:term)", array(':term' => $t));
		}
		$this->dbh->commit();
		
		/** link terms to posts */
		$this->dbh->begin();
		foreach($terms as $term => $freq) {
			$resultset = $this->dbh->query("SELECT tid FROM terms WHERE term = :term", 
			array(':term' => $term));
			
			if($resultset &&  ($row = $resultset->fetch()) != false) {
				$this->dbh->query("INSERT IGNORE post_terms(pid, tid, frequency) "
				."VALUES(:pid, :tid, :freq)", array(
					':pid' 	=> $postid, 
					':tid' 	=> $row[0],
					':freq' => $freq 
				));
			}
		}
		$this->dbh->commit();
	}
	
	/*
		Do term discovery for posts that are in the DB
	*/
	public function termdiscovery() {
		$resultset = $this->dbh->query("SELECT postID, postContent FROM posts "
		."WHERE language = 'en' AND postID NOT IN (SELECT pid FROM post_terms) "
		."ORDER BY postID DESC LIMIT 50", array());
		
		/** discover terms in post description */
		$terms = array();
		if($resultset) {
			while(($row = $resultset->fetch()) != false) {
				$words = explode(" ", $row[1]);
				$clean = array_map(function($w) {
					return strtolower(trim($w, " ,.?!&/()#0123456789_-:;"));
				}, $words);
				$terms[$row[0]] = array_count_values($clean);
			}
		}

		/** filter out long words (urls etc) and insert into db */
		foreach($terms as $post => $termcounts) {
			$cleaned = array_filter($termcounts, function($term) {
				return strlen($term) > 2 && strlen($term) < 20;
			}, ARRAY_FILTER_USE_KEY);
			
			if(count($cleaned) > 0) {
				$this->insertterms($post, $cleaned);
			}
		}
		
		$this->calculatetfidf();
	}
	
	/*
		calculate tf-idf (last 36 hours) for trending topics
	*/
	public function calculatetfidf() {
		$day = $this->now - 129600;
		
		$this->dbh->begin();
		/** zero out all the things, we only want stats for last 36 hours */
		$this->dbh->query("UPDATE terms "
		."SET term_freq = NULL, doc_freq = NULL, tf_idf = NULL", array());
		
		$resultset = $this->dbh->query("SELECT COUNT(*) FROM posts "
		."WHERE language = 'en' AND serverTimestamp > :day", array(':day' => $day));
		
		if($resultset && ($row = $resultset->fetch()) != false && $row[0] > 0) {
			/** set term frequency and document frequency for recent posts */			
			$this->dbh->query("UPDATE terms AS t "
			."SET t.term_freq = ("
				."SELECT SUM(frequency) FROM post_terms AS pt "
				."WHERE pt.tid = t.tid AND pt.pid IN ("
					."SELECT postID FROM posts "
					."WHERE serverTimestamp > :day1 and language = 'en'"
				.")"
			."), t.doc_freq = ("
				."SELECT COUNT(*) FROM post_terms AS pt "
				."WHERE pt.tid = t.tid AND pt.pid IN ("
					."SELECT postID FROM posts "
					."WHERE serverTimestamp > :day2 and language = 'en'"
				.")"
			.")", array(':day1' => $day, ':day2' => $day));
			
			/** 
				tf-idf calculation:
					row[0] is total number of posts (N) in last 24 hours 
					tf_idf = tf * log(N / idf)		
			*/
			$this->dbh->query("UPDATE terms "
			."SET tf_idf = term_freq * LOG(:ndocs / doc_freq) "
			."WHERE term_freq > 0 AND doc_freq > 0", 
			array(':ndocs' => $row[0]));
		}
			
		$this->dbh->commit();
	}
}

?>
