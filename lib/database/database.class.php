<?php
/* lib/database/database.class.php - DNS-WI
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
/* Database layout class */
class database {
	private static $conn = NULL;
	
	/**
	 * Connects to SQL Server
	 * 
	 * @param	string		$host
	 * @param	string		$user
	 * @param	string		$pw
	 * @param	string		$db
	 */
	public static function connect($host, $user, $pw, $db) { }
	
	/**
	 * Sends a database query to SQL server.
	 *
	 * @param	string		$res 		a database query
	 * @return 	integer					id of the query result
	 */
	public static function query ($res) { }
	
	/**
	 * Escapes a string for use in sql query.
	 *
	 * @param	string		$res 		a database query
	 * @return	string
	 */
	public static function escape ($res) { return $res; }
	
	/**
	 * Gets a row from SQL database query result.
	 *
	 * @param	string		$res		a database query
	 * @return 				array		a row from result
	 */
	public static function fetch_array ($res) { }
	
	/**
	 * Counts number of rows in a result returned by a SELECT query.
	 *
	 * @param	string		$res	a database query	
	 * @return 	integer				number of rows in a result
	 */
	public static function num_rows ($res) { }
	
	/**
	 * Returns SQL error number for last error.
	 *
	 * @return 	integer		PostgreSQL error number
	 */
	public static function error () { }
	
	/**
	 * unescapes SQL bytea data values
	 * @param	string		$data 		escaped string
	 * @return	string
	 */
	public static function unescape ($data) { return $data; }
}
?>
