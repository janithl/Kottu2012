<?php

/*
	dbconn.class.php, the Database Connection class

	09/05/12	Based on GPL code written by Thimal Jayasooriya 
				for the Colombo bus route project [janith]

*/

class DBConn
{
	private $db;
	
	/* db connection properties = EDIT HERE */
	private $dbhost = "localhost";
	private $dbname = "kottu";
	private $dbuser = "root";
	private $dbpwd = '';
	
	public function __construct($conn = true) {
	
		if ($conn) {
			$this->connect();
		}
	}


	function connect() {
	
		$dsn = "mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname;

	    try {
			$this->db = new PDO($dsn, $this->dbuser, $this->dbpwd);
			$this->db->exec("set names utf8");
		} 
		catch (PDOException $e) {
			print "Database connection failed: " . $e->getMessage() . "<br/>";
			die();    
		}
	}

	function query($sql, $params) {		
		
		$statement = $this->db->prepare($sql);
	    	$result = $statement->execute($params);
		
		return $result? $statement:$result;
	}
}

?>
