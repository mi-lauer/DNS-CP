<?php
/* lib/database/mysql.pdo.database.class.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */
/* This is the database implementation for MySQL4.1 or higher using the mysql extension. */
if (!extension_loaded("pdo")) die("Missing <a href=\"http://www.php.net/manual/en/book.pdo.php\">PDO</a> PHP extension."); // check if extension loaded
if (!extension_loaded("pdo_mysql")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-mysql.php\">pdo_mysql</a> PHP extension."); // check if extension loaded
class DB extends pdo_database {
	private static $conn = NULL;
	/**
	 * Connects to MySQL Server
	 * 
	 * @param	string		$host
	 * @param	string		$user
	 * @param	string		$pw
	 * @param	string		$db
	 */
	public static function connect($host, $user, $pw, $db) {
		self::$conn = new PDO("mysql:host=".$host.";dbname=".$db, $user, $pw);
	}
	
	/*
	 * close the database connection
	 */
	public static function close () {
		self::$conn = NULL;
	}
	/**
	 * Sends a database query to MySQL server.
	 *
	 * @param	string		$res 		a database query
	 * @param	string		$bind 		
	 * @return 	integer					id of the query result
	 */
	public static function query ($res, $bind = array()) {
		$query = self::$conn->prepare($res);
		if(is_array($bind) && !empty($bind))
			return $query->execute($bind);
		else
			return $query->execute();
		
	}

	
	/**
	 * Gets a row from MySQL database query result.
	 *
	 * @param	string		$res		a database query
	 * @return 				array		a row from result
	 */
	public static function fetch_array ($res) {
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Counts number of rows in a result returned by a SELECT query.
	 *
	 * @param	string		$res	a database query	
	 * @return 	integer				number of rows in a result
	 */
	public static function num_rows ($res) {
		return $res->rowCount();
	}
}
?>
