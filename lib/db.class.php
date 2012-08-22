<?php

/*
	static wrapper for dbconn objects
*/

class DB
{
	private static $db = null;

	public static function connect() {
	
	    if(self::$db == null) {
		    $db = new DBConn();
		}
		
		return $db;
	}
}

?>
