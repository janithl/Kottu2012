<?php

/*
	dbconn.class.php, the Database Connection class

	09/05/12	Based on GPL code written by Thimal Jayasooriya for the
				Colombo bus route project [janith]
	
	12/05/12	Moved DB settings over to the config file [janith] 

*/

class DBConn
{
	private $db;
	
	public function __construct($conn = true) {
	
		if ($conn) {
			$this->connect();
		}
	}

	function connect() {
	
		$dsn = 'mysql:host='.config('dbhost').';dbname='.config('dbname');

	    try {
			$this->db = new PDO($dsn, config('dbuser'), config('dbpwd'));
			$this->db->exec("set names utf8");
		} 
		catch (PDOException $e) {
			print "Database connection failed: {$e->getMessage()} <br/>";
			die();    
		}
	}

	function query($sql, $params) {		
		
		$statement = $this->db->prepare($sql);
	    $result = $statement->execute($params);
		
		return $result ? $statement : $result;
	}
}

?>
