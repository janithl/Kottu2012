<?php

/*
    Admin class

    20/08/12	Started this [janith]
	
*/

class KottuAdmin
{
	private $dbh;

	public function __construct() {
	
		$this->dbh = DB::connect();
	}
    
    /*
		Fetch blogs by active, limit and search string
    */
    public function fetchblogs($active, $limit = -1, $search = false){

        $blogs = array();
        
        if($limit >= 0) {    
		    if($search) {
		    
				$resultset = $this->dbh->query("SELECT bid, blogName, blogURL, "
				."blogRSS, MAX(serverTimestamp) FROM blogs AS b, posts AS p "
				."WHERE b.bid = p.blogID AND active = :act AND (blogName LIKE "
				.":str1 OR blogURL LIKE :str2) GROUP BY bid LIMIT :limit, 30", 
				array(':act' => $active, ':str1' => "%$search%", 
				':str2' => "%$search%", ':limit' => $limit));        
		    }
		    else {

				$resultset = $this->dbh->query("SELECT bid, blogName, blogURL, "
				."blogRSS, MAX(serverTimestamp) FROM blogs AS b, posts AS p "
				."WHERE b.bid = p.blogID AND active = :act GROUP BY bid "
				."LIMIT :limit, 30", array(':act'=>$active, ':limit'=>$limit));
			}
		}
		else {
		
			$resultset = $this->dbh->query("SELECT bid, blogName, blogURL, "
			."blogRSS, MAX(serverTimestamp) FROM blogs AS b, posts AS p WHERE "
			."b.bid = p.blogID AND active = :act GROUP BY bid", 
			array(':act'=>$active));
		} 

        if($resultset) {
            while (($row = $resultset->fetch()) != false) {

                $b['bid']	= $row[0];
                $b['name']	= $row[1];
                $b['url']	= $row[2];
                $b['feed']	= $row[3];
				$b['ts']	= $row[4];
				
                $blogs[] = $b;
            }
        }

        return $blogs;
    }
    
    /* 
    	Get 10 most recently added blogs (by bid)
    */
    public function getrecentblogs() {
    
        $blogs = array();
            
    	$resultset = $this->dbh->query("SELECT bid, blogName, blogURL, blogRSS"
		." FROM blogs WHERE active = 1 ORDER BY bid DESC LIMIT 5");
		
		if($resultset) {
            while (($row = $resultset->fetch()) != false) {

                $b['bid']	= $row[0];
                $b['name']	= $row[1];
                $b['url']	= $row[2];
                $b['feed']	= $row[3];
				$b['ts']	= $row[4];
				
                $blogs[] = $b;
            }
        }

        return $blogs;
    }
	
    /*
        Set active to 0 on a blog (effectively deleting it from Kottu without
        removing the record from the db)
    */
    public function deleteblog($id) {

        return $this->dbh->query("UPDATE blogs SET active = 0 WHERE bid = :id", 
                                    array(':id' => $id));
    }

    /*
        Set active to 1, undeleting a deleted blog, or approving a blog that
        requested to join
    */
    public function undeleteblog($id) {

        return $this->dbh->query("UPDATE blogs SET active = 1 WHERE bid = :id", 
                                    array(':id' => $id));
    }
	
    /*
        Add a blog to the database
    */
    public function addblog($name, $url, $rss, $admin = false) {

        $active = ($admin) ? 1 : 2;
        
        if(trim($name) != '' && trim($url) != '' && trim($rss) != '') {

        	$this->dbh->query("INSERT INTO blogs(blogName, blogURL, blogRSS, "
        	."active) VALUES(:name, :url, :rss, :act)", 
            array(	':name' => $name,
	                ':url'  => $url,
	                ':rss'  => $rss,
	                ':act'  => $active));
		}
    }
    
    /*
        Update blog details in database
    */
    public function updateblog($id, $name, $url, $rss) {

        $this->dbh->query("UPDATE blogs SET blogName = :name, blogURL = :url, "
        ."blogRSS = :rss WHERE bid = :id", 
                array(	':name' => $name,
		                ':url'  => $url,
		                ':rss'  => $rss,
		                ':id'   => $id));

    }
    
    /*
        Gets all the details of a single blog
    */
    public function getblogdeets($id) {

        $b = array();

        $resultset = $this->dbh->query("SELECT blogName, blogURL, blogRSS "
        ."FROM blogs WHERE bid = :id", array(':id' => $id));

        if($resultset && ($row = $resultset->fetch()) != false) {

            $b['id']	= $id;
            $b['name']	= $row[0];
            $b['url']	= $row[1];
            $b['feed']	= $row[2];
        }

        return $b;
    }
    
    /*
        Authenticate user
    */
    public function authuser($user, $hash, $salt) {
    
        $auth = false;

        $resultset = $this->dbh->query("SELECT hash FROM users WHERE "
        ."userid = :uid", array(':uid' => $user));

        if($resultset && ($row = $resultset->fetch()) != false) {

            $auth = (sha1($row[0] . $salt) === $hash);
        }

        return $auth;
    }    
    	
    /*
        Add a user login record
    */
    public function addlogin($user, $ip, $uagent) {

        $this->dbh->query("INSERT INTO logins(user, ipaddr, timestamp, "
        ."useragent) VALUES(:user, :ip, :ts, :ua)", 
                array(	':user' => $user,
		                ':ip'   => $ip,
		                ':ts'   => time(),
		                ':ua'   => $uagent));

    }
    
    /*
        Get last 10 user login records
    */
    public function getrecentlogins() {

        $logins = array();

        $resultset = $this->dbh->query("SELECT user, ipaddr, timestamp, "
        ."useragent FROM logins ORDER BY id DESC LIMIT 10");

        if($resultset) {
            while (($row = $resultset->fetch()) != false) {

                $l['user']	= $row[0];
                $l['ip']	= $row[1];
                $l['ts']	= $row[2];
                $l['uagent']= $row[3];

                $logins[] = $l;
            }
        }

        return $logins;
    }
    
    /*
    	Get language breakdown of posts
    */
    public function getlangdeets() {
    
    	$lang = array();
    	
    	$resultset = $this->dbh->query("SELECT language, COUNT(postID) FROM "
		."posts WHERE servertimestamp > (unix_timestamp(now()) - 86400) "
		."GROUP BY language");
		
		$totalposts = 0;
		if($resultset) {

			while(($array = $resultset->fetch()) != false) {
	
				$lid	= $array[0];
				$count	= $array[1];

				$lang[$lid] = ($count > 0) ? $count : 1;

				$totalposts += $count;
			}
		}
		$lang['total'] = $totalposts;
		
		return $lang;
	}
	
	/*
		Get timewise breakdown of posts and clicks
	*/
	public function getpostclickbreakdown() {
	
		$timevalues = array();
		$now = time();

		$polltimes  = array(24, 21, 18, 15, 12, 9, 6, 3);
		foreach($polltimes as $time)
		{
			$start	= $now - (($time - $polltimes[7]) * 3600);
			$end	= $now - ($time * 3600);

			$rs1 = $this->dbh->query("SELECT COUNT(postID) FROM posts WHERE "
					."serverTimestamp < :start AND serverTimestamp > :end",
					array(':start' => $start, ':end' => $end));

			$rs2 = $this->dbh->query("SELECT COUNT(ip) FROM clicks WHERE "
					."timestamp < :start AND timestamp > :end",
					array(':start' => $start, ':end' => $end));

			if($rs1 & $rs2)
			{
				$resarray1 = $rs1->fetch();
				$resarray2 = $rs2->fetch();

				$resvalues = array($resarray1[0], $resarray2[0]);

				$timevalues[$time] = $resvalues;
			}
		}
		
		return $timevalues;
	}
    
    /*
        Get IP addresses with most number of clicks in last 24 hours
    */    
    public function gettopclickers() {

		$clickers = array();

		$resultset 	= $this->dbh->query("SELECT ip, count(timestamp) FROM "
		."clicks WHERE timestamp > (unix_timestamp(now()) - 86400) GROUP BY "
		."ip ORDER BY count(timestamp) DESC LIMIT 5");
				
		if($resultset) {

			while(($row = $resultset->fetch()) != false) {
				$clickers[] = array('ip' => $row[0], 'count' => $row[1]);
			}
		}

		return $clickers;
	}

    /*
        Get most popular blogs in last 30 days
    */
	public function popularblogs() {
	
		$blogs = array();

		$resultset = $this->dbh->query("SELECT b.bid, b.blogName, b.blogURL, "
		."COUNT(p.postID), AVG(p.postBuzz) FROM posts AS p, blogs AS b WHERE "
		."p.serverTimestamp > (unix_timestamp(now()) - 2592000) AND "
		."b.bid = p.blogID GROUP BY p.blogID HAVING COUNT(p.postID) >= 3 "
		."ORDER BY AVG(p.postBuzz) DESC LIMIT 5");

		if($resultset) {
			while(($row = $resultset->fetch()) != false) {
			
				$blogs[] = array(	'bid'	=> $row[0],
									'name'	=> $row[1],
									'url'	=> $row[2],
									'posts'	=> $row[3],
									'buzz'	=> (int)($row[4] * 100));
			}
		}
	
		return $blogs;
	}

    /*
        Get the buzz for the last 5 posts of a blog
    */
	public function postbuzz($bid) {

		$buzzes = array();

		$resultset = $this->dbh->query("SELECT postBuzz FROM posts WHERE "
		."blogID = :bid ORDER BY serverTimestamp DESC LIMIT 5", 
		array(':bid' => $bid));

		if($resultset) {	
			while(($row = $resultset->fetch()) != false) {
		
				$buzzes[] = (int)(100 * $row[0]);
			}
		}
	
		return $buzzes;
	}

	/*
        View PHP error log
    */
	public function viewlog() {

		$entries = array();
		
		$file 	= '../../logs/php_errors.log';
		$fp 	= fopen($file, 'r');
		
		if($fp && filesize($file) > 0) {
       	
       		$fcont		= fread($fp, filesize($file));
       		$entries	= explode("\n", $fcont);
       	}
	
		return $entries;
	}

    /*
        URL based routing
    */    
    public function route($path, $t) {
    
    	session_start(); 
    
    	if($path == "login" && isset($_POST['user'])) {

			if($this->authuser($_POST['user'], $_POST['pwd'], $_POST['salt'])){
	
				
	        	$_SESSION['kottu']['authuser'] = $_POST['user'];
	        	$this->addlogin($_POST['user'], $_SERVER['REMOTE_ADDR'], 
	                                $_SERVER['HTTP_USER_AGENT']);
	                                
	        	echo "<script>document.location = '", config("basepath"), 
	        						"/admin';</script>";
			}
			else {
				
				    $t->fail = true;
					$t->render("admin/login.php");
					die();
			}
		}
		else if(isset($_SESSION['kottu']['authuser'])) {
		
			$t->username    = $_SESSION['kottu']['authuser'];
			$t->title	    = strlen($path) > 0 ? $path : 'home';
			$t->title       .= ": Kottu Admin";
			$t->page		= $path;
			
			switch($path) {
			
				case 'addblog':
					$t->eblog = array();
	    			$t->render("admin/headsmall.php");
	    			$t->render("admin/blogdeets.php");
	    			$t->render("admin/tail.php");
	    			break;
	    			
	    		case 'editblog':		 	
					$t->eblog = $this->getblogdeets($_GET['id']);
					$t->render("admin/headsmall.php");
					$t->render("admin/blogdeets.php");
					$t->render("admin/tail.php");
					break;
					
				case 'blogdeetsubmit':
					if(isset($_POST['bname'], $_POST['burl'], $_POST['brss'],
								$_POST['bid'])) {
	            
	        			$this->updateblog($_POST['bid'], $_POST['bname'], 
								$_POST['burl'], $_POST['brss']);
	        			echo "<script>window.close()</script>";
					}
					else if(isset($_POST['bname'], $_POST['burl'], 
								$_POST['brss'])) {
							
						$this->addblog($_POST['bname'], $_POST['burl'], 
							                        $_POST['brss'], true);
						echo "<script>window.close()</script>";
					}
					break;
				
				case 'deleteblog':
					echo ($this->deleteblog($_GET['id'])) ? '200' : '400';
					break;
					
				case 'restoreblog':
					echo ($this->undeleteblog($_GET['id'])) ? '200' : '400';
					break;
					
				case 'modify':
					$t->pageno = isset($_GET['page']) ? (int)$_GET['page'] : 0;
					$search = (isset($_GET['search']) && 
					trim($_GET['search']) != '') ? $_GET['search'] : false;
					$t->blogs = $this->fetchblogs(1, $t->pageno * 20, $search);
					$t->undelete = false;
					$t->render("admin/head.php");
					$t->render("admin/modify.php");
					$t->render("admin/tail.php");
					break;

				case 'trash':
					$t->blogs = $this->fetchblogs(0);
					$t->undelete = true;
					$t->render("admin/head.php");
					$t->render("admin/modify.php");
					$t->render("admin/tail.php");
					break;

				case 'approve':
					$t->blogs = $this->fetchblogs(2);
					$t->render("admin/head.php");
					$t->render("admin/approve.php");
					$t->render("admin/tail.php");
					break;
					
				case 'stats':
					$t->clickers = $this->gettopclickers();
					$t->popblogs = $this->popularblogs();
					$t->langs	 = $this->getlangdeets();
					$t->tvalues	 = $this->getpostclickbreakdown();
	
					$rpb = array();
					foreach($t->popblogs as $p) {
						$rpb[] = $this->postbuzz($p['bid']);
					}
					$t->rpb		= $rpb;
					
					$t->render("admin/head.php");
					$t->render("admin/stats.php");
					$t->render("admin/tail.php");				
					break;
					
				case 'logview':
					$t->entries = $this->viewlog();
					$t->render("admin/head.php");
					$t->render("admin/logview.php");
					$t->render("admin/tail.php");
					break;
					
				case 'logout':
					session_unset(); 
					session_destroy();
					echo "<script>document.location = '", config('basepath'), 
								"';</script>";
					break;
					
				default:
					$t->joins   = count($this->fetchblogs(2));
					$t->logins  = $this->getrecentlogins();
					$t->rblogs	= $this->getrecentblogs();
					$t->render("admin/head.php");
					$t->render("admin/home.php");
					$t->render("admin/tail.php");
					break;
			}
		}
		else {

			$t->fail = false;
			$t->render("admin/login.php");
			die();        
		}
    }
}

?>
