<?php
/* lib/database/sqlite3.database.class.php - DNS-WI
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
/* This is the database implementation for SQLite3. */
if (!extension_loaded("sqlite3")) die("Missing <a href=\"http://www.php.net/manual/en/book.sqlite3.php\">sqlite3</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;
	
	/**
	 * Connects to SQLite database
	 * 
	 * @param	NULL		$host
	 * @param	NULL		$user
	 * @param	NULL		$pw
	 * @param	string		$db
	 */
	public static function connect($host, $user, $pw, $db) {
		self::$conn = new SQLite3("database/".$db);
	}
	
	/**
	 * Sends a database query to SQLite database.
	 *
	 * @param	string		$res 		a database query
	 * @return 	integer					id of the query result
	 */
	public static function query ($res) {
		return self::$conn->query($res);
	}
	
	/**
	 * Escapes a string for use in sql query.
	 *
	 * @param	string		$res 		a database query
	 * @return	string
	 */
	public static function escape ($res) {
		return self::$conn->escapeString($res);
	}
	
	/**
	 * Gets a row from SQLite database query result
	 *
	 * @param	string		$res		a database query
	 * @return 				array		a row from result
	 */
	public static function fetch_array ($res) {
		return $res->fetchArray(SQLITE3_ASSOC);
	}
	
	/**
	 * Counts number of rows in a result returned by a SELECT query.
	 *
	 * @param	string		$res	a database query	
	 * @return 	integer				number of rows in a result
	 */
	public static function num_rows ($res) {
		$count = 0;
		while ($row = self::fetch_array($res)) { $count++; }
		return $count;
	}
	
	/**
	 * Returns SQLite error description for last error.
	 *
	 * @return 	string		SQLite error description
	 */
	public static function error () {
		return self::$conn->lastErrorMsg();
	}
}
?>
