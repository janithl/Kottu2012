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

	public function connect() {
	
		$dsn = 'mysql:host='.config('dbhost').';dbname='.config('dbname');

		try {
			$this->db = new PDO($dsn, config('dbuser'), config('dbpwd'));
			$this->db->exec("set names utf8");
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		} 
		catch (PDOException $e) {
			die("Database connection failed: {$e->getMessage()} <br/>");
		}
	}
	
	public function begin()		{ $this->db->beginTransaction(); }
	public function commit()	{ $this->db->commit(); }

	public function query($sql, $params = array()) {		
		
		$statement = $this->db->prepare($sql);
		if($statement) {
			$result = $statement->execute($params);
			return $result ? $statement : $result;
		} else {
			die("Preparing statement failed: {$sql} <br/>");
		}
	}
}

?>
