<?php
/* lib/mysqli.database.class.php - DNS-WI
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
/* MySQL Improved Extension class */
require_once("database.class.php");
if (!extension_loaded("mysqli")) die("Missing <a href=\"http://www.php.net/manual/en/book.mysqli.php\">mysqli</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;
	
	public static function connect($host, $user, $pw, $db) {
		self::$conn = mysqli_connect($host, $user, $pw, $db);
	}
	
	public static function query ($res) {
		return mysqli_query(self::$conn, $res);
	}
	
	public static function escape ($res) {
		return mysqli_real_escape_string(self::$conn, $res);
	}
	
	public static function fetch_array ($res) {
		return mysqli_fetch_array($res);
	}
	
	public static function num_rows ($res) {
		return mysqli_num_rows($res);
	}
	
	public static function error () {
		// DOES CURRENTLY NOT WORK, NEEDS TO BE FIXED!
		// ISSUE: Does not respond anything.
		return mysqli_error(self::$conn);
	}
}
?>
